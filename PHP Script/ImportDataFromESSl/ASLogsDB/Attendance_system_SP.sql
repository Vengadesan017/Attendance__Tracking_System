
USE [ASLogs]

DROP PROCEDURE IF EXISTS dbo.AttendanceDataFromASLogsToAttendanceSystem;  
GO

CREATE PROCEDURE [dbo].[AttendanceDataFromASLogsToAttendanceSystem]
AS
BEGIN
    BEGIN TRY
    SET NOCOUNT ON;
    SET XACT_ABORT OFF;
    DECLARE @OperationType NVARCHAR(30)='';
    DECLARE @AffectedRowIDs NVARCHAR(255) = '';

    -- For Insert Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs] WHERE [OperationType]=1)
        BEGIN
            SET @OperationType = @OperationType + ' INSERT';

            IF OBJECT_ID('tempdb..#TempTableInsert') IS NOT NULL
                DROP TABLE #TempTableInsert;

            SELECT * INTO #TempTableInsert 
            FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs] 
            WHERE [OperationType] = 1;               


            INSERT INTO [MSI].[Attendance_System].[dbo].[Attendance]
            ([essl_id], [employee_id], [a_date], [Shift_id], [Attendance], [Status_code], [in_time], [out_time]) 
            SELECT [essl_id], [employee_id], TRY_CONVERT(date, [a_date]), [Shift_id], [Attendance], [Status_code], TRY_CONVERT(time, [in_time]), TRY_CONVERT(time, [out_time])
            FROM #TempTableInsert;

            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs]
                WHERE [a_id] in (SELECT a_id from #TempTableInsert) AND OperationType=1;  
                
                IF @@ERROR=0 AND @@ROWCOUNT > 0
                BEGIN
                    IF OBJECT_ID('tempdb..#TempTableInsert') IS NOT NULL
                        DROP TABLE #TempTableInsert;
                END;
                ELSE
                    RAISERROR('Attendance date inserted but not deleted in ASLogs table',16,1);
            END;
            ELSE
                RAISERROR('Error occurred during insertion',16,1);
     
        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableInsert') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableInsert;
            DROP TABLE #TempTableInsert;
        END;
    END CATCH;



    -- For Update Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs] WHERE [OperationType]=2)
        BEGIN
            SET @OperationType = @OperationType + ' UPDATE';

            IF OBJECT_ID('tempdb..#TempTableUpdate') IS NOT NULL
                DROP TABLE #TempTableUpdate;

            SELECT * INTO #TempTableUpdate 
            FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs] 
            WHERE [OperationType] = 2
            ORDER BY [a_id];              



            DECLARE @a_id BIGINT, @essl_id INT, @employee_id INT, @a_date DATETIME, @Shift_id INT, @Attendance VARCHAR(255), @Status_code VARCHAR(255), @in_time NVARCHAR(255), @out_time NVARCHAR(255);

            DECLARE update_cursor CURSOR FOR
            SELECT [a_id],[essl_id], [employee_id], [a_date], [Shift_id], [Attendance], [Status_code], [in_time], [out_time]
            FROM #TempTableUpdate
            ORDER BY a_id

            OPEN update_cursor;

            FETCH NEXT FROM update_cursor INTO @a_id, @essl_id, @employee_id, @a_date, @Shift_id, @Attendance, @Status_code, @in_time, @out_time;

            WHILE @@FETCH_STATUS = 0
            BEGIN
                UPDATE A
                SET 
                    [employee_id] = @employee_id,
                    [a_date] = TRY_CONVERT(date, @a_date),
                    [Shift_id] = @Shift_id,
                    [Attendance] = @Attendance,
                    [Status_code] = @Status_code,
                    [in_time] = TRY_CONVERT(time, @in_time),
                    [out_time] = TRY_CONVERT(time, @out_time)
                FROM 
                    [MSI].[Attendance_System].[dbo].[Attendance] AS A
                WHERE 
                    A.[essl_id] = @essl_id;


            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs]
                WHERE [a_id] = @a_id AND OperationType=2;
                
            END;


                FETCH NEXT FROM update_cursor INTO @a_id, @essl_id, @employee_id, @a_date, @Shift_id, @Attendance, @Status_code, @in_time, @out_time;
            END

            CLOSE update_cursor;
            DEALLOCATE update_cursor;

        IF OBJECT_ID('tempdb..#TempTableUpdate') IS NOT NULL
            DROP TABLE #TempTableUpdate;


        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableUpdate') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableUpdate;
            DROP TABLE #TempTableUpdate;
        END;
    END CATCH;


    -- For Delete Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs] WHERE [OperationType]=3)
        BEGIN
            SET @OperationType = @OperationType + ' DELETE';

            IF OBJECT_ID('tempdb..#TempTableDELETE') IS NOT NULL
                DROP TABLE #TempTableDELETE;

            SELECT * INTO #TempTableDELETE 
            FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs] 
            WHERE [OperationType] = 3;               


            DELETE FROM [MSI].[Attendance_System].[dbo].[Attendance] 
            WHERE [essl_id]
            IN (SELECT [essl_id] FROM #TempTableDELETE);

            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[AttendanceLogs]
                WHERE [a_id] in (SELECT a_id from #TempTableDELETE) AND OperationType=3;
                
                IF @@ERROR=0 AND @@ROWCOUNT > 0
                BEGIN
                    IF OBJECT_ID('tempdb..#TempTableDELETE') IS NOT NULL
                        DROP TABLE #TempTableDELETE;
                END;
                ELSE
                    RAISERROR('Attendance date deleted AS DB but not deleted in ASLogs DB',16,1);
            END;
            ELSE
                RAISERROR('Error occurred during deletion',16,1);

        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableDELETE') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableDELETE;
            DROP TABLE #TempTableDELETE;
        END;
    END CATCH;


    END TRY
    BEGIN CATCH
        

        DECLARE @WhereFrom NVARCHAR(100) = 'SP => AttendanceLog =>'+@OperationType; 
        DECLARE @DateTime DATETIME = CONVERT(DATETIME, DATEADD(MINUTE, 330, GETUTCDATE()));       
        DECLARE @ErrorSummary NVARCHAR(255) = LEFT(ERROR_MESSAGE(), 255);
        DECLARE @ErrorSeverity INT = ERROR_SEVERITY();
        DECLARE @ErrorState INT = ERROR_STATE();

        IF OBJECT_ID('tempdb..#TempTableInsert') IS NOT NULL
            DROP TABLE #TempTableInsert;

        IF OBJECT_ID('tempdb..#TempTableUpdate') IS NOT NULL
            DROP TABLE #TempTableUpdate;

        IF OBJECT_ID('tempdb..#TempTableDELETE') IS NOT NULL
            DROP TABLE #TempTableDELETE;

        INSERT INTO [ASLogs].[dbo].ErrorLog (ErrorDateTime,WhereFrom,AffectedRows, ErrorMessage, ErrorSeverity, ErrorState)
        VALUES (@DateTime,@WhereFrom,@AffectedRowIDs, @ErrorSummary, @ErrorSeverity, @ErrorState);


    END CATCH;


END






-- For Employee data

DROP PROCEDURE IF EXISTS dbo.EmployeeDataFromASLogsToAttendanceSystem;  
GO

CREATE PROCEDURE [dbo].[EmployeeDataFromASLogsToAttendanceSystem]
AS
BEGIN
    BEGIN TRY
    SET NOCOUNT ON;
    SET XACT_ABORT OFF;
    DECLARE @OperationType NVARCHAR(30)='';
    DECLARE @AffectedRowIDs NVARCHAR(255) = '';

    -- For Insert Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs] WHERE [OperationType]=1)
        BEGIN
            SET @OperationType = @OperationType + ' INSERT';

            IF OBJECT_ID('tempdb..#TempTableInsertE') IS NOT NULL
                DROP TABLE #TempTableInsertE;

            SELECT * INTO #TempTableInsertE 
            FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs] 
            WHERE [OperationType] = 1;               


            INSERT INTO [MSI].[Attendance_System].[dbo].[Employee]
            ([EmployeeCode], [employee_id], [employee_name], [Gender], [Father_name], [Mother_name], [email], [Department_id], [Designation], [DOJ], [DOR], [DOB], [Employee_type], [is_working], [Blood_group],[Address]) 
            SELECT [EmployeeCode], [employee_id], [employee_name], [Gender], [Father_name], [Mother_name], [email], [Department_id], [Designation], TRY_CONVERT(date, [DOJ]), TRY_CONVERT(date, [DOR]), TRY_CONVERT(date, [DOB]), [Employee_type], [is_working], [Blood_group],[Address]
            FROM #TempTableInsertE;

            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs]
                WHERE [e_id] in (SELECT e_id from #TempTableInsertE) AND OperationType=1;  
                
                IF @@ERROR=0 AND @@ROWCOUNT > 0
                BEGIN
                    IF OBJECT_ID('tempdb..#TempTableInsertE') IS NOT NULL
                        DROP TABLE #TempTableInsertE;
                END;
                ELSE
                    RAISERROR('EmployeeLogs date inserted but not deleted in ASLogs table',16,1);
            END;
            ELSE
                RAISERROR('Error occurred during insertion',16,1);
     
        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableInsertE') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableInsertE;
            DROP TABLE #TempTableInsertE;
        END;
    END CATCH;



    -- For Update Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs] WHERE [OperationType]=2)
        BEGIN
            SET @OperationType = @OperationType + ' UPDATE';

            IF OBJECT_ID('tempdb..#TempTableUpdateE') IS NOT NULL
                DROP TABLE #TempTableUpdateE;

            SELECT * INTO #TempTableUpdateE 
            FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs] 
            WHERE [OperationType] = 2
            ORDER BY [e_id];              



            DECLARE @e_id BIGINT,@EmployeeCode NVARCHAR(50), @employee_id INT, @employee_name NVARCHAR(50), @Gender NVARCHAR(255), @Father_name VARCHAR(255), @Mother_name VARCHAR(255), @email NVARCHAR(255), @Department_id INT,@Designation NVARCHAR(255), @DOJ DATETIME, @DOR DATETIME, @DOB DATETIME, @Employee_type VARCHAR(255), @is_working VARCHAR(255), @Blood_group NVARCHAR(255), @Address NVARCHAR(255);

            DECLARE update_cursor CURSOR FOR
            SELECT [e_id],[EmployeeCode], [employee_id], [employee_name], [Gender], [Father_name], [Mother_name], [email], [Department_id], [Designation],[DOJ],[DOR],[DOB], [Employee_type], [is_working], [Blood_group],[Address]
            FROM #TempTableUpdateE
            ORDER BY e_id

            OPEN update_cursor;

            FETCH NEXT FROM update_cursor INTO @e_id, @EmployeeCode, @employee_id, @employee_name, @Gender, @Father_name, @Mother_name, @email, @Department_id, @Designation, @DOJ, @DOR, @DOB, @Employee_type, @is_working,@Blood_group,@Address;

            WHILE @@FETCH_STATUS = 0
            BEGIN

            -- TRY_CONVERT(date, @a_date),
                UPDATE A
                SET 
                    [EmployeeCode] = @EmployeeCode,
                    [employee_name] = @employee_name,
                    [Gender] = @Gender,
                    [Father_name] = @Father_name,
                    [Mother_name] = @Mother_name,
                    [email] = @email,
                    [Department_id] = @Department_id,
                    [Designation] = @Designation,
                    [DOJ] =TRY_CONVERT(date, @DOJ),
                    [DOR] =TRY_CONVERT(date, @DOR),
                    [DOB] =TRY_CONVERT(date, @DOB),
                    [Employee_type] = @Employee_type,
                    [is_working] = @is_working,
                    [Blood_group] = @Blood_group,
                    [Address] = @Address

                FROM 
                    [MSI].[Attendance_System].[dbo].[Employee] AS A
                WHERE 
                    A.[employee_id] = @employee_id;


            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs]
                WHERE [e_id] = @e_id AND OperationType=2;
                
            END;


                FETCH NEXT FROM update_cursor INTO @e_id, @EmployeeCode, @employee_id, @employee_name, @Gender, @Father_name, @Mother_name, @email, @Department_id, @Designation, @DOJ, @DOR, @DOB, @Employee_type, @is_working,@Blood_group,@Address;
            END

            CLOSE update_cursor;
            DEALLOCATE update_cursor;

        IF OBJECT_ID('tempdb..#TempTableUpdateE') IS NOT NULL
            DROP TABLE #TempTableUpdateE;


        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableUpdateE') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableUpdateE;
            DROP TABLE #TempTableUpdateE;
        END;
    END CATCH;


    -- For Delete Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs] WHERE [OperationType]=3)
        BEGIN
            SET @OperationType = @OperationType + ' DELETE';

            IF OBJECT_ID('tempdb..#TempTableDeleteE') IS NOT NULL
                DROP TABLE #TempTableDeleteE;

            SELECT * INTO #TempTableDeleteE 
            FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs] 
            WHERE [OperationType] = 3;               


            DELETE FROM [MSI].[Attendance_System].[dbo].[Employee] 
            WHERE [employee_id]
            IN (SELECT [employee_id] FROM #TempTableDeleteE);

            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[EmployeeLogs]
                WHERE [e_id] in (SELECT e_id from #TempTableDeleteE) AND OperationType=3;
                
                IF @@ERROR=0 AND @@ROWCOUNT > 0
                BEGIN
                    IF OBJECT_ID('tempdb..#TempTableDeleteE') IS NOT NULL
                        DROP TABLE #TempTableDeleteE;
                END;
                ELSE
                    RAISERROR('Employee date deleted AS DB but not deleted in ASLogs DB',16,1);
            END;
            ELSE
                RAISERROR('Error occurred during deletion',16,1);

        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableDeleteE') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableDeleteE;
            DROP TABLE #TempTableDeleteE;
        END;
    END CATCH;


    END TRY
    BEGIN CATCH
        

        DECLARE @WhereFrom NVARCHAR(100) = 'SP => EmployeeeLog =>'+@OperationType; 
        DECLARE @DateTime DATETIME = CONVERT(DATETIME, DATEADD(MINUTE, 330, GETUTCDATE()));       
        DECLARE @ErrorSummary NVARCHAR(255) = LEFT(ERROR_MESSAGE(), 255);
        DECLARE @ErrorSeverity INT = ERROR_SEVERITY();
        DECLARE @ErrorState INT = ERROR_STATE();

        IF OBJECT_ID('tempdb..#TempTableInsertE') IS NOT NULL
            DROP TABLE #TempTableInsertE;

        IF OBJECT_ID('tempdb..#TempTableUpdateE') IS NOT NULL
            DROP TABLE #TempTableUpdateE;

        IF OBJECT_ID('tempdb..#TempTableDeleteE') IS NOT NULL
            DROP TABLE #TempTableDeleteE;

        INSERT INTO [ASLogs].[dbo].ErrorLog (ErrorDateTime,WhereFrom,AffectedRows, ErrorMessage, ErrorSeverity, ErrorState)
        VALUES (@DateTime,@WhereFrom,@AffectedRowIDs, @ErrorSummary, @ErrorSeverity, @ErrorState);


    END CATCH;


END




-- For Department data

DROP PROCEDURE IF EXISTS dbo.DepartmentDataFromASLogsToAttendanceSystem;  
GO

CREATE PROCEDURE [dbo].[DepartmentDataFromASLogsToAttendanceSystem]
AS
BEGIN
    BEGIN TRY
    SET NOCOUNT ON;
    SET XACT_ABORT OFF;
    DECLARE @OperationType NVARCHAR(30)='';
    DECLARE @AffectedRowIDs NVARCHAR(255) = '';

    -- For Insert Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs] WHERE [OperationType]=1)
        BEGIN
            SET @OperationType = @OperationType + ' INSERT';

            IF OBJECT_ID('tempdb..#TempTableInsertD') IS NOT NULL
                DROP TABLE #TempTableInsertD;

            SELECT * INTO #TempTableInsertD 
            FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs] 
            WHERE [OperationType] = 1;               


            INSERT INTO [MSI].[Attendance_System].[dbo].[Department]
            ([department_id], [department_name],  [user_id],[division_id]) 
            SELECT [department_id], [department_name],-1,-1
            FROM #TempTableInsertD;

            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs]
                WHERE [d_id] in (SELECT d_id from #TempTableInsertD) AND OperationType=1;  
                
                IF @@ERROR=0 AND @@ROWCOUNT > 0
                BEGIN
                    IF OBJECT_ID('tempdb..#TempTableInsertD') IS NOT NULL
                        DROP TABLE #TempTableInsertD;
                END;
                ELSE
                    RAISERROR('DepartmentLogs date inserted but not deleted in ASLogs table',16,1);
            END;
            ELSE
                RAISERROR('Error occurred during insertion',16,1);
     
        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableInsertD') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableInsertD;
            DROP TABLE #TempTableInsertD;
        END;
    END CATCH;



    -- For Update Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs] WHERE [OperationType]=2)
        BEGIN
            SET @OperationType = @OperationType + ' UPDATE';

            IF OBJECT_ID('tempdb..#TempTableUpdateD') IS NOT NULL
                DROP TABLE #TempTableUpdateD;

            SELECT * INTO #TempTableUpdateD 
            FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs] 
            WHERE [OperationType] = 2
            ORDER BY [d_id];              



            DECLARE @d_id BIGINT,@department_id INT, @department_name NVARCHAR(100);

            DECLARE update_cursor CURSOR FOR
            SELECT [d_id],[department_id], [department_name]
            FROM #TempTableUpdateD
            ORDER BY d_id

            OPEN update_cursor;

            FETCH NEXT FROM update_cursor INTO @d_id, @department_id, @department_name;

            WHILE @@FETCH_STATUS = 0
            BEGIN

                UPDATE A
                SET 
                    [department_name] = @department_name
                FROM 
                    [MSI].[Attendance_System].[dbo].[Department] AS A
                WHERE 
                    A.[department_id] = @department_id;


            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs]
                WHERE [d_id] = @d_id AND OperationType=2;
                
            END;


                FETCH NEXT FROM update_cursor INTO @d_id, @department_id, @department_name;
            END

            CLOSE update_cursor;
            DEALLOCATE update_cursor;

        IF OBJECT_ID('tempdb..#TempTableUpdateD') IS NOT NULL
            DROP TABLE #TempTableUpdateD;


        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableUpdateD') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableUpdateD;
            DROP TABLE #TempTableUpdateD;
        END;
    END CATCH;


    -- For Delete Operation
    BEGIN TRY

        IF EXISTS(SELECT * FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs] WHERE [OperationType]=3)
        BEGIN
            SET @OperationType = @OperationType + ' DELETE';

            IF OBJECT_ID('tempdb..#TempTableDeleteD') IS NOT NULL
                DROP TABLE #TempTableDeleteD;

            SELECT * INTO #TempTableDeleteD 
            FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs] 
            WHERE [OperationType] = 3;               


            DELETE FROM [MSI].[Attendance_System].[dbo].[Department] 
            WHERE [department_id]
            IN (SELECT [department_id] FROM #TempTableDeleteD);

            IF @@ERROR=0 AND @@ROWCOUNT > 0
            BEGIN
                DELETE FROM [MSI\MSI2].[ASLogs].[dbo].[DepartmentLogs]
                WHERE [d_id] in (SELECT d_id from #TempTableDeleteD) AND OperationType=3;
                
                IF @@ERROR=0 AND @@ROWCOUNT > 0
                BEGIN
                    IF OBJECT_ID('tempdb..#TempTableDeleteD') IS NOT NULL
                        DROP TABLE #TempTableDeleteD;
                END;
                ELSE
                    RAISERROR('Department date deleted AS DB but not deleted in ASLogs DB',16,1);
            END;
            ELSE
                RAISERROR('Error occurred during deletion',16,1);

        END;

    END TRY
    BEGIN CATCH
        IF OBJECT_ID('tempdb..#TempTableDeleteD') IS NOT NULL
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [essl_id]), 255)
            FROM #TempTableDeleteD;
            DROP TABLE #TempTableDeleteD;
        END;
    END CATCH;


    END TRY
    BEGIN CATCH
        

        DECLARE @WhereFrom NVARCHAR(100) = 'SP => DepartmentLog =>'+@OperationType; 
        DECLARE @DateTime DATETIME = CONVERT(DATETIME, DATEADD(MINUTE, 330, GETUTCDATE()));       
        DECLARE @ErrorSummary NVARCHAR(255) = LEFT(ERROR_MESSAGE(), 255);
        DECLARE @ErrorSeverity INT = ERROR_SEVERITY();
        DECLARE @ErrorState INT = ERROR_STATE();

        IF OBJECT_ID('tempdb..#TempTableInsertD') IS NOT NULL
            DROP TABLE #TempTableInsertD;

        IF OBJECT_ID('tempdb..#TempTableUpdateD') IS NOT NULL
            DROP TABLE #TempTableUpdateD;

        IF OBJECT_ID('tempdb..#TempTableDeleteD') IS NOT NULL
            DROP TABLE #TempTableDeleteD;

        INSERT INTO [ASLogs].[dbo].ErrorLog (ErrorDateTime,WhereFrom,AffectedRows, ErrorMessage, ErrorSeverity, ErrorState)
        VALUES (@DateTime,@WhereFrom,@AffectedRowIDs, @ErrorSummary, @ErrorSeverity, @ErrorState);


    END CATCH;


END
