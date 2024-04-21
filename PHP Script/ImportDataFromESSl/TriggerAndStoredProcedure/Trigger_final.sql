USE [etimetracklite1]

drop TRIGGER IF EXISTS [dbo].[EmployeeDataModified] 
go
CREATE TRIGGER [dbo].[EmployeeDataModified]
ON [dbo].[Employees]
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    DECLARE @InsertedID INT, @UpdatedID INT, @DeletedID INT;


    -- Handle INSERT operation
    IF EXISTS(SELECT * FROM inserted) AND NOT EXISTS(SELECT * FROM deleted)
    BEGIN
        -- Loop through the inserted table
        DECLARE cursor_inserted CURSOR FOR
        SELECT [EmployeeCode] FROM inserted;

        OPEN cursor_inserted;
        FETCH NEXT FROM cursor_inserted INTO @InsertedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN
     
            EXEC [Attendance_System].[dbo].[InsertEmployeeDataFromEsslToAttendanceSystem] @InsertedID;

            FETCH NEXT FROM cursor_inserted INTO @InsertedID;
        END;

        CLOSE cursor_inserted;
        DEALLOCATE cursor_inserted;
    END;

    -- Handle DELETE operation
    IF EXISTS(SELECT * FROM deleted) AND NOT EXISTS(SELECT * FROM inserted)
    BEGIN
        -- Loop through the deleted table
        DECLARE cursor_deleted CURSOR FOR
        SELECT [EmployeeCode] FROM deleted;

        OPEN cursor_deleted;
        FETCH NEXT FROM cursor_deleted INTO @DeletedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN
            EXEC [Attendance_System].[dbo].[DeleteEmployeeDataFromEsslToAttendanceSystem] @DeletedID;

            FETCH NEXT FROM cursor_deleted INTO @DeletedID;
        END;

        CLOSE cursor_deleted;
        DEALLOCATE cursor_deleted;
    END;

    -- Handle UPDATE operation
    IF EXISTS(SELECT * FROM deleted) AND EXISTS(SELECT * FROM inserted)
    BEGIN
        -- Loop through the deleted table
        DECLARE cursor_updated CURSOR FOR
        SELECT [EmployeeCode] FROM deleted;

        OPEN cursor_updated;
        FETCH NEXT FROM cursor_updated INTO @UpdatedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN

            EXEC [Attendance_System].[dbo].[UpdateEmployeeDataFromEsslToAttendanceSystem] @UpdatedID;

            FETCH NEXT FROM cursor_updated INTO @UpdatedID;
        END;

        CLOSE cursor_updated;
        DEALLOCATE cursor_updated;
    END;
END


drop TRIGGER IF EXISTS [dbo].[BiometricAttendanceDataModified] 
go
CREATE TRIGGER [dbo].[BiometricAttendanceDataModified]
ON [dbo].[AttendanceLogs]
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    DECLARE @InsertedID INT, @UpdatedID INT, @DeletedID INT;


    -- Handle INSERT operation
    IF EXISTS(SELECT * FROM inserted) AND NOT EXISTS(SELECT * FROM deleted)
    BEGIN
        -- Loop through the inserted table
        DECLARE cursor_inserted CURSOR FOR
        SELECT [AttendanceLogId] FROM inserted;

        OPEN cursor_inserted;
        FETCH NEXT FROM cursor_inserted INTO @InsertedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN
            EXEC [Attendance_System].[dbo].[InsertAttendanceDataFromEsslToAttendanceSystem] @InsertedID;

            FETCH NEXT FROM cursor_inserted INTO @InsertedID;
        END;

        CLOSE cursor_inserted;
        DEALLOCATE cursor_inserted;
    END;

    -- Handle DELETE operation
    IF EXISTS(SELECT * FROM deleted) AND NOT EXISTS(SELECT * FROM inserted)
    BEGIN
        -- Loop through the deleted table
        DECLARE cursor_deleted CURSOR FOR
        SELECT [AttendanceLogId] FROM deleted;

        OPEN cursor_deleted;
        FETCH NEXT FROM cursor_deleted INTO @DeletedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN
            EXEC [Attendance_System].[dbo].[DeleteAttendanceDataFromEsslToAttendanceSystem] @DeletedID;

            FETCH NEXT FROM cursor_deleted INTO @DeletedID;
        END;

        CLOSE cursor_deleted;
        DEALLOCATE cursor_deleted;
    END;

    -- Handle UPDATE operation
    IF EXISTS(SELECT * FROM deleted) AND EXISTS(SELECT * FROM inserted)
    BEGIN
        -- Loop through the deleted table
        DECLARE cursor_updated CURSOR FOR
        SELECT [AttendanceLogId] FROM deleted;

        OPEN cursor_updated;
        FETCH NEXT FROM cursor_updated INTO @UpdatedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN

            EXEC [Attendance_System].[dbo].[UpdateAttendanceDataFromEsslToAttendanceSystem] @UpdatedID;

            FETCH NEXT FROM cursor_updated INTO @UpdatedID;
        END;

        CLOSE cursor_updated;
        DEALLOCATE cursor_updated;
    END;
END

drop TRIGGER IF EXISTS [dbo].[DepartmentDataModified] 
go
CREATE TRIGGER [dbo].[DepartmentDataModified]
ON [dbo].[Departments]
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    DECLARE @InsertedID INT, @UpdatedID INT, @DeletedID INT;


    -- Handle INSERT operation
    IF EXISTS(SELECT * FROM inserted) AND NOT EXISTS(SELECT * FROM deleted)
    BEGIN
        -- Loop through the inserted table
        DECLARE cursor_inserted CURSOR FOR
        SELECT [DepartmentId] FROM inserted;

        OPEN cursor_inserted;
        FETCH NEXT FROM cursor_inserted INTO @InsertedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN
     
            EXEC [Attendance_System].[dbo].[InsertDepartmentDataFromEsslToAttendanceSystem] @InsertedID;

            FETCH NEXT FROM cursor_inserted INTO @InsertedID;
        END;

        CLOSE cursor_inserted;
        DEALLOCATE cursor_inserted;
    END;

    -- Handle DELETE operation
    IF EXISTS(SELECT * FROM deleted) AND NOT EXISTS(SELECT * FROM inserted)
    BEGIN
        -- Loop through the deleted table
        DECLARE cursor_deleted CURSOR FOR
        SELECT [DepartmentId] FROM deleted;

        OPEN cursor_deleted;
        FETCH NEXT FROM cursor_deleted INTO @DeletedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN
            EXEC [Attendance_System].[dbo].[DeleteDepartmentDataFromEsslToAttendanceSystem] @DeletedID;

            FETCH NEXT FROM cursor_deleted INTO @DeletedID;
        END;

        CLOSE cursor_deleted;
        DEALLOCATE cursor_deleted;
    END;

    -- Handle UPDATE operation
    IF EXISTS(SELECT * FROM deleted) AND EXISTS(SELECT * FROM inserted)
    BEGIN
        -- Loop through the deleted table
        DECLARE cursor_updated CURSOR FOR
        SELECT [DepartmentId] FROM deleted;

        OPEN cursor_updated;
        FETCH NEXT FROM cursor_updated INTO @UpdatedID;

        WHILE @@FETCH_STATUS = 0
        BEGIN

            EXEC [Attendance_System].[dbo].[UpdateDepartmentDataFromEsslToAttendanceSystem] @UpdatedID;

            FETCH NEXT FROM cursor_updated INTO @UpdatedID;
        END;

        CLOSE cursor_updated;
        DEALLOCATE cursor_updated;
    END;
END

