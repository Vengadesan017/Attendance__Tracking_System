
USE [Attendance_System]

DROP PROCEDURE IF EXISTS [dbo].[ImportEmployeeAndDepartmentData];  
GO

CREATE PROCEDURE [dbo].[ImportEmployeeAndDepartmentData]
AS
BEGIN
    IF EXISTS (SELECT 1 FROM sys.servers WHERE name = 'MSI\MSI2')
    BEGIN
        SET NOCOUNT ON;

        -- For Insert
        INSERT INTO [MSI].[Attendance_System].[dbo].[Attendance]
            ([essl_id], [employee_id], [a_date], [Shift_id], [in_time], [out_time], [Attendance], [Status_code])
        SELECT
            [AttendanceLogId],
            [EmployeeId],
            TRY_CONVERT(date, [AttendanceDate]) AS [a_date],
            [ShiftId],
            TRY_CONVERT(time, [InTime]) AS [in_time],
            TRY_CONVERT(time, [OutTime]) AS [out_time],
            [Status],
            [StatusCode]
        FROM [MSI\MSI2].[etimetracklite1].[dbo].[Attendancelogs] 
        where AttendancelogId > ISNULL((SELECT MAX(essl_id) FROM [MSI].[Attendance_System].[dbo].[Attendance]), 0)

        -- For Update         
        UPDATE A
        SET 
            [Shift_id] = B.[ShiftId],
            [Attendance] = B.[Status],
            [Status_code] = B.[StatusCode],
            [in_time] = CONVERT(time, B.[InTime]),
            [out_time] = CONVERT(time, B.[OutTime])
        FROM 
            [MSI].[Attendance_System].[dbo].[Attendance] AS A
        INNER JOIN 
            (
                SELECT *
                FROM [MSI\MSI2].[etimetracklite1].[dbo].[Attendancelogs]
                WHERE 
                    Convert(date,AttendanceDate) IN (Convert(date,DATEADD(day, 0, GETDATE())), Convert(date,DATEADD(day, -1, GETDATE())))
            ) B
        ON 
            A.[essl_id] = B.[AttendancelogId]
        WHERE
            A.a_date IN (Convert(date,DATEADD(day, 0, GETDATE())), Convert(date,DATEADD(day, -1, GETDATE()))) AND
            (A.[Shift_id] != B.[ShiftId] OR
            A.[Attendance] != B.[Status] OR
            A.[Status_code] != B.[StatusCode] OR
            A.[in_time] != CONVERT(time, B.[InTime]) OR
            A.[out_time] != CONVERT(time, B.[OutTime]))

        -- For Delete
        DELETE FROM  [MSI].[Attendance_System].[dbo].[Attendance]
        WHERE [essl_id] NOT IN (
            SELECT [AttendancelogId]
            FROM [MSI\MSI2].[etimetracklite1].[dbo].[Attendancelogs] 
            WHERE TRY_CONVERT(date,AttendanceDate) IN (TRY_CONVERT(date,DATEADD(day, 0, GETDATE())), TRY_CONVERT(date,DATEADD(day, -1, GETDATE())))
        ) 
        AND a_date IN (TRY_CONVERT(date,DATEADD(day, 0, GETDATE())), TRY_CONVERT(date,DATEADD(day, -1, GETDATE())))



    END
    ELSE
        PRINT 'Linked server "MSI\MSI2" not found.';

END;
