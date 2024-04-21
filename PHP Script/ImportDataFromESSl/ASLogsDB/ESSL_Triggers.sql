USE [etimetracklite1]

-- For Employees
drop TRIGGER IF EXISTS [dbo].[EmployeeDataModified] 
go
CREATE TRIGGER [dbo].[EmployeeDataModified]
ON [dbo].[Employees]

AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    BEGIN TRY
    SET NOCOUNT ON;
    SET XACT_ABORT OFF;
    DECLARE @OperationType NVARCHAR(20);

    -- Handle INSERT operation
    IF EXISTS(SELECT * FROM inserted) AND NOT EXISTS(SELECT * FROM deleted)
    BEGIN
        SET @OperationType = 'INSERT';
        INSERT INTO [ASLogs].[dbo].[EmployeeLogs]
        ([OperationType],[EmployeeCode], [employee_id], [employee_name], [Gender], [Father_name], [Mother_name], [email], [Department_id], [Designation], [DOJ], [DOR], [DOB],[Employee_type], [is_working], [Blood_group],
        [Address])
        SELECT 
            '1',    
            [EmployeeCode],
            [EmployeeId],
            [EmployeeName],
            [Gender],
            [FatherName],
            [MotherName],
            [Email],
            [DepartmentId],
            [Designation],
            [DOJ],
            [DOR],
            [DOB],
            [EmployementType],
            [Status],
            [BLOODGROUP],
            [PermanentAddress]
        from inserted;
    END;

    -- Handle DELETE operation
    IF EXISTS(SELECT * FROM deleted) AND NOT EXISTS(SELECT * FROM inserted)
    BEGIN
        SET @OperationType = 'DELETE';
        INSERT INTO [ASLogs].[dbo].[EmployeeLogs] ([OperationType], [employee_id])
        SELECT '3', [EmployeeId]
        FROM deleted;
    END;

    -- Handle UPDATE operation
    IF EXISTS(SELECT * FROM deleted) AND EXISTS(SELECT * FROM inserted)
    BEGIN
        SET @OperationType = 'UPDATE';
        INSERT INTO [ASLogs].[dbo].[EmployeeLogs]
        ([OperationType],[EmployeeCode], [employee_id], [employee_name], [Gender], [Father_name], [Mother_name], [email], [Department_id], [Designation], [DOJ], [DOR], [DOB],[Employee_type], [is_working], [Blood_group],
        [Address])
        SELECT 
            '2',     
            [EmployeeCode],
            [EmployeeId],
            [EmployeeName],
            [Gender],
            [FatherName],
            [MotherName],
            [Email],
            [DepartmentId],
            [Designation],
            [DOJ],
            [DOR],
            [DOB],
            [EmployementType],
            [Status],
            [BLOODGROUP],
            [PermanentAddress]
        from inserted;

    END;
    END TRY
    BEGIN CATCH
        DECLARE @AffectedRowIDs NVARCHAR(255) = '';
        DECLARE @WhereFrom NVARCHAR(100) = 'Trigger => Employees => '+@OperationType; 
        DECLARE @DateTime DATETIME = CONVERT(DATETIME, DATEADD(MINUTE, 330, GETUTCDATE()));       
        DECLARE @ErrorSummary NVARCHAR(255) = LEFT(ERROR_MESSAGE(), 255);
        DECLARE @ErrorSeverity INT = ERROR_SEVERITY();
        DECLARE @ErrorState INT = ERROR_STATE();


        IF @OperationType = 'INSERT' OR @OperationType = 'UPDATE'
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [EmployeeId]), 255)
            FROM inserted;
        END;
        ELSE IF @OperationType = 'DELETE'
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [EmployeeId]), 255)
            FROM deleted;
        END;


        INSERT INTO [ASLogs].[dbo].ErrorLog (ErrorDateTime,WhereFrom,AffectedRows, ErrorMessage, ErrorSeverity, ErrorState)
        VALUES (@DateTime,@WhereFrom,@AffectedRowIDs, @ErrorSummary, @ErrorSeverity, @ErrorState);


    END CATCH
    
END;






-- For AttendanceLogs
drop TRIGGER IF EXISTS [dbo].[AttendanceDataModified] 
go

CREATE TRIGGER [dbo].[AttendanceDataModified]
ON [dbo].[AttendanceLogs]
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    BEGIN TRY
    -- COMMIT;
    SET NOCOUNT ON;
    SET XACT_ABORT OFF;
    DECLARE @OperationType NVARCHAR(20);

    -- Handle INSERT operation
    IF EXISTS(SELECT * FROM inserted) AND NOT EXISTS(SELECT * FROM deleted)
    BEGIN
        SET @OperationType = 'INSERT';
        INSERT INTO [ASLogs].[dbo].[AttendanceLogs]
        ([OperationType],[essl_id], [employee_id], [a_date], [Shift_id], [Attendance], [Status_code], [in_time], [out_time])
        SELECT 
            '1',    
            [AttendanceLogId],
            [EmployeeId],
            [AttendanceDate],
            [ShiftId],
            [Status],
            [StatusCode],
            [InTime],
            [OutTime]
        from inserted;
    END;

    -- Handle DELETE operation
    IF EXISTS(SELECT * FROM deleted) AND NOT EXISTS(SELECT * FROM inserted)
    BEGIN
        SET @OperationType = 'DELETE';
        INSERT INTO [ASLogs].[dbo].[AttendanceLogs] ([OperationType], [essl_id])
        SELECT '3', [AttendanceLogId]
        FROM deleted;
    END;

    -- Handle UPDATE operation
    IF EXISTS(SELECT * FROM deleted) AND EXISTS(SELECT * FROM inserted)
    BEGIN
        SET @OperationType = 'UPDATE';
        INSERT INTO [ASLogs].[dbo].[AttendanceLogs]
        ([OperationType],[essl_id], [employee_id], [a_date], [Shift_id], [Attendance], [Status_code], [in_time], [out_time])
        SELECT 
            '2',     
            [AttendanceLogId],
            [EmployeeId],
            [AttendanceDate],
            [ShiftId],
            [Status],
            [StatusCode],
            [InTime],
            [OutTime]
        from inserted;

    END;
    END TRY
    BEGIN CATCH
        DECLARE @AffectedRowIDs NVARCHAR(255) = '';
        DECLARE @WhereFrom NVARCHAR(100) = 'Trigger => AttendanceLogs => '+@OperationType; 
        DECLARE @DateTime DATETIME = CONVERT(DATETIME, DATEADD(MINUTE, 330, GETUTCDATE()));       
        DECLARE @ErrorSummary NVARCHAR(255) = LEFT(ERROR_MESSAGE(), 255);
        DECLARE @ErrorSeverity INT = ERROR_SEVERITY();
        DECLARE @ErrorState INT = ERROR_STATE();


        IF @OperationType = 'INSERT' OR @OperationType = 'UPDATE'
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [AttendanceLogId]), 255)
            FROM inserted;
        END;
        ELSE IF @OperationType = 'DELETE'
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [AttendanceLogId]), 255)
            FROM deleted;
        END;


        INSERT INTO [ASLogs].[dbo].ErrorLog (ErrorDateTime,WhereFrom,AffectedRows, ErrorMessage, ErrorSeverity, ErrorState)
        VALUES (@DateTime,@WhereFrom,@AffectedRowIDs, @ErrorSummary, @ErrorSeverity, @ErrorState);


    END CATCH
    
END;




-- For Departments
drop TRIGGER IF EXISTS [dbo].[DepartmentDataModified] 
go
CREATE TRIGGER [dbo].[DepartmentDataModified]
ON [dbo].[Departments]
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    BEGIN TRY
    SET NOCOUNT ON;
    SET XACT_ABORT OFF;
    DECLARE @OperationType NVARCHAR(20);

    -- Handle INSERT operation
    IF EXISTS(SELECT * FROM inserted) AND NOT EXISTS(SELECT * FROM deleted)
    BEGIN
        SET @OperationType = 'INSERT';
        INSERT INTO [ASLogs].[dbo].[DepartmentLogs]
        ([OperationType],[department_id], [department_name])
        SELECT 
            '1',    
            [DepartmentId],
            [DepartmentFName]
        from inserted;
    END;

    -- Handle DELETE operation
    IF EXISTS(SELECT * FROM deleted) AND NOT EXISTS(SELECT * FROM inserted)
    BEGIN
        SET @OperationType = 'DELETE';
        INSERT INTO [ASLogs].[dbo].[DepartmentLogs] ([OperationType], [department_id])
        SELECT '3', [DepartmentId]
        FROM deleted;
    END;

    -- Handle UPDATE operation
    IF EXISTS(SELECT * FROM deleted) AND EXISTS(SELECT * FROM inserted)
    BEGIN
        SET @OperationType = 'UPDATE';
        INSERT INTO [ASLogs].[dbo].[DepartmentLogs]
        ([OperationType],[department_id], [department_name])
        SELECT 
            '2',     
            [DepartmentId],
            [DepartmentFName]
        from inserted;

    END;
    END TRY
    BEGIN CATCH
        DECLARE @AffectedRowIDs NVARCHAR(255) = '';
        DECLARE @WhereFrom NVARCHAR(100) = 'Trigger => DepartmentLogs => '+@OperationType; 
        DECLARE @DateTime DATETIME = CONVERT(DATETIME, DATEADD(MINUTE, 330, GETUTCDATE()));       
        DECLARE @ErrorSummary NVARCHAR(255) = LEFT(ERROR_MESSAGE(), 255);
        DECLARE @ErrorSeverity INT = ERROR_SEVERITY();
        DECLARE @ErrorState INT = ERROR_STATE();


        IF @OperationType = 'INSERT' OR @OperationType = 'UPDATE'
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [DepartmentId]), 255)
            FROM inserted;
        END;
        ELSE IF @OperationType = 'DELETE'
        BEGIN
            SELECT @AffectedRowIDs = LEFT(ISNULL(@AffectedRowIDs + ',', '') + CONVERT(NVARCHAR(10), [DepartmentId]), 255)
            FROM deleted;
        END;


        INSERT INTO [ASLogs].[dbo].ErrorLog (ErrorDateTime,WhereFrom,AffectedRows, ErrorMessage, ErrorSeverity, ErrorState)
        VALUES (@DateTime,@WhereFrom,@AffectedRowIDs, @ErrorSummary, @ErrorSeverity, @ErrorState);


    END CATCH
    
END;





























