USE [Attendance_System]

DROP PROCEDURE IF EXISTS dbo.InsertAttendanceDataFromEsslToAttendanceSystem;  
GO
DROP PROCEDURE IF EXISTS  dbo.UpdateAttendanceDataFromEsslToAttendanceSystem;  
GO
DROP PROCEDURE IF EXISTS  dbo.DeleteAttendanceDataFromEsslToAttendanceSystem;  
GO
CREATE PROCEDURE [dbo].[InsertAttendanceDataFromEsslToAttendanceSystem]
    @InsertedId INT 
AS
BEGIN
    
DECLARE @AttendanceDate datetime,
        @EmployeeId int,
        @InTime nvarchar(255),
        @OutTime nvarchar(255),
        @ShiftId int,
        @Status nvarchar(255),
        @StatusCode nvarchar(255),
        @DateValue date,
		@InTimeValue time,
		@OutTimeValue time;

    SELECT
        @AttendanceDate = [AttendanceDate],
        @EmployeeId = [EmployeeId],
        @InTime = [InTime],
        @OutTime = [OutTime],
        @ShiftId = [ShiftId],
        @Status = [Status],
        @StatusCode = [StatusCode]

       
    FROM [etimetracklite1].[dbo].[Attendancelogs]
    WHERE [AttendanceLogId] = @InsertedId;

	SET @DateValue = CONVERT(date, @AttendanceDate);
	SET @InTimeValue = CONVERT(time, @InTime);
	SET @OutTimeValue = CONVERT(time, @OutTime);

    INSERT INTO [Attendance_System].[dbo].[Attendance]
    ([essl_id], [employee_id], [a_date], [Shift_id], [in_time], [out_time], [Attendance], [Status_code])
    VALUES
    (@InsertedId, @EmployeeId, @DateValue,@ShiftId, @InTimeValue, @OutTimeValue, @Status, @StatusCode);

END

GO 

CREATE PROCEDURE [dbo].[UpdateAttendanceDataFromEsslToAttendanceSystem]
    @UpdatedID INT 
AS
BEGIN
    
DECLARE @AttendanceDate datetime,
        @EmployeeId int,
        @InTime nvarchar(255),
        @OutTime nvarchar(255),
        @ShiftId int,
        @Status nvarchar(255),
        @StatusCode nvarchar(255),
        @DateValue date,
        @InTimeValue time,
		@OutTimeValue time;

    SELECT
        @AttendanceDate = [AttendanceDate],
        @EmployeeId = [EmployeeId],
        @InTime = [InTime],
        @OutTime = [OutTime],
        @ShiftId = [ShiftId],
        @Status = [Status],
        @StatusCode = [StatusCode]


       
    FROM [etimetracklite1].[dbo].[Attendancelogs]
    WHERE [AttendanceLogId] = @UpdatedID;


	SET @DateValue = CONVERT(date, @AttendanceDate);
	SET @InTimeValue = CONVERT(time, @InTime);
	SET @OutTimeValue = CONVERT(time, @OutTime);

    UPDATE [Attendance_System].[dbo].[Attendance]
    SET
        
        [employee_id] = @EmployeeId,
        [a_date] = @DateValue,
        [Shift_id] = @ShiftId,
        [in_time] = @InTimeValue,
        [out_time] = @OutTimeValue,
        [Attendance] = @Status,
        [Status_code] = @StatusCode       
    WHERE
    [essl_id] = @UpdatedID;
END

GO

CREATE PROCEDURE [dbo].[DeleteAttendanceDataFromEsslToAttendanceSystem]
    @DeletedID INT 
AS
BEGIN

    DELETE FROM [Attendance]
    WHERE [essl_id] = @DeletedID;



  

END


DROP PROCEDURE IF EXISTS dbo.InsertEmployeeDataFromEsslToAttendanceSystem;  
GO
DROP PROCEDURE IF EXISTS dbo.UpdateEmployeeDataFromEsslToAttendanceSystem;  
GO
DROP PROCEDURE IF EXISTS dbo.DeleteEmployeeDataFromEsslToAttendanceSystem;  
GO
CREATE PROCEDURE [dbo].[InsertEmployeeDataFromEsslToAttendanceSystem]
    @InsertedId INT 
AS
BEGIN
    
DECLARE @EmployeeId int,
        @EmployeeName nvarchar(255),
        @EmployeeCode nvarchar(255),
        @Gender nvarchar(255),
        @DepartmentId int,
        @Designation nvarchar(255),
        @DOJ datetime,
        @DOR datetime,
        @EmployementType nvarchar(255),
        @Status nvarchar(255),
        @FatherName nvarchar(255),
        @MotherName nvarchar(255),
        @PermanentAddress nvarchar(255),
        @Email nvarchar(255),
        @DOB datetime,
        @BLOODGROUP nvarchar(255),
        @DOBdate date,
        @DOJdate date,
        @DORdate date;


SELECT 
    @EmployeeId = [EmployeeId],
    @EmployeeName = [EmployeeName],
    @EmployeeCode = [EmployeeCode],
    @Gender = [Gender],
    @DepartmentId = [DepartmentId],
    @Designation = [Designation],
    @DOJ = [DOJ],
    @DOR = [DOR],
    @EmployementType = [EmployementType],
    @Status = [Status],
    @FatherName = [FatherName],
    @MotherName = [MotherName],
    @PermanentAddress = [PermanentAddress],
    @Email = [Email],
    @DOB = [DOB],
    @BLOODGROUP = [BLOODGROUP]
FROM [etimetracklite1].[dbo].[Employees] WHERE [EmployeeCode] =@InsertedId;


    SET @DOBdate = CONVERT(date, @DOB);
    SET @DOJdate = CONVERT(date, @DOJ);
    SET @DORdate = CONVERT(date, @DOR);
   

    INSERT INTO [Attendance_System].[dbo].[Employee]
    ([EmployeeCode], [employee_id], [employee_name], [Gender], [Father_name], [Mother_name], [email], [Department_id], [Designation], [DOJ], [DOR], [DOB],[Employee_type], [is_working], [Blood_group],
    [Address])
    VALUES
    (@EmployeeCode, @EmployeeId, @EmployeeName,@Gender, @FatherName, @MotherName, @Email, @DepartmentId, @Designation,@DOJdate, @DORdate, @DOBdate,@EmployementType, @Status, @BLOODGROUP,
    @PermanentAddress);


END

GO 

CREATE PROCEDURE [dbo].[UpdateEmployeeDataFromEsslToAttendanceSystem]
    @UpdatedID INT 
AS
BEGIN
DECLARE @EmployeeId int,
        @EmployeeName nvarchar(255),
        @EmployeeCode nvarchar(255),
        @Gender nvarchar(255),
        @DepartmentId int,
        @Designation nvarchar(255),
        @DOJ datetime,
        @DOR datetime,
        @EmployementType nvarchar(255),
        @Status nvarchar(255),
        @FatherName nvarchar(255),
        @MotherName nvarchar(255),
        @PermanentAddress nvarchar(255),
        @Email nvarchar(255),
        @DOB datetime,
        @BLOODGROUP nvarchar(255),
        @DOBdate date,
        @DOJdate date,
        @DORdate date;


SELECT 
    @EmployeeId = [EmployeeId],
    @EmployeeName = [EmployeeName],
    @EmployeeCode = [EmployeeCode],
    @Gender = [Gender],
    @DepartmentId = [DepartmentId],
    @Designation = [Designation],
    @DOJ = [DOJ],
    @DOR = [DOR],
    @EmployementType = [EmployementType],
    @Status = [Status],
    @FatherName = [FatherName],
    @MotherName = [MotherName],
    @PermanentAddress = [PermanentAddress],
    @Email = [Email],
    @DOB = [DOB],
    @BLOODGROUP = [BLOODGROUP]
FROM [etimetracklite1].[dbo].[Employees] WHERE [EmployeeCode] = @UpdatedID;

    SET @DOBdate = CONVERT(date, @DOB);
    SET @DOJdate = CONVERT(date, @DOJ);
    SET @DORdate = CONVERT(date, @DOR);

UPDATE [Attendance_System].[dbo].[Employee]
SET
    [employee_id] = @EmployeeId,
    [employee_name] = @EmployeeName,
    [Gender] = @Gender,
    [Father_name] = @FatherName,
    [Mother_name] = @MotherName,
    [email] = @Email,
    [Department_id] = @DepartmentId,    
    [Designation] = @Designation,
    [DOJ] = @DOJdate,
    [DOR] = @DORdate,
    [DOB] = @DOBdate,
    [Employee_type] = @EmployementType,
    [is_working] = @Status,
    [Blood_group] = @BLOODGROUP,
    [Address] = @PermanentAddress
WHERE
    [EmployeeCode] = @UpdatedID;



END

GO

CREATE PROCEDURE [dbo].[DeleteEmployeeDataFromEsslToAttendanceSystem]
    @DeletedID INT 
AS
BEGIN

    DELETE FROM [Employee]
    WHERE [EmployeeCode] = @DeletedID;

END

DROP PROCEDURE IF EXISTS dbo.[InsertDepartmentDataFromEsslToAttendanceSystem];  
DROP PROCEDURE IF EXISTS dbo.[UpdateDepartmentDataFromEsslToAttendanceSystem];  
DROP PROCEDURE IF EXISTS dbo.[DeleteDepartmentDataFromEsslToAttendanceSystem];  
GO

-- Now create the procedures

CREATE PROCEDURE [dbo].[InsertDepartmentDataFromEsslToAttendanceSystem]
    @InsertedId INT 
AS
BEGIN
    DECLARE @DepartmentName NVARCHAR(255);

    -- Disable the identity property temporarily
    SET IDENTITY_INSERT [Attendance_System].[dbo].[Department] ON;

    -- Get the department name from the source table
    SELECT @DepartmentName = [DepartmentFName]
    FROM [etimetracklite1].[dbo].[Departments] WHERE [DepartmentId] = @InsertedId;

    -- Perform the insert with the desired identity value
    INSERT INTO [Attendance_System].[dbo].[Department]
    ([department_id], [department_name])
    VALUES
    (@InsertedId, @DepartmentName);

    -- Re-enable the identity property
    SET IDENTITY_INSERT [Attendance_System].[dbo].[Department] OFF;
END
GO

CREATE PROCEDURE [dbo].[UpdateDepartmentDataFromEsslToAttendanceSystem]
    @UpdatedID INT 
AS
BEGIN
    DECLARE @DepartmentName nvarchar(255);

    SELECT @DepartmentName = [DepartmentFName] FROM [etimetracklite1].[dbo].[Departments] WHERE [DepartmentId] = @UpdatedID;

    UPDATE [Attendance_System].[dbo].[Department]
    SET
        [department_name] = @DepartmentName
    WHERE
        [department_id] = @UpdatedID;
END
GO

CREATE PROCEDURE [dbo].[DeleteDepartmentDataFromEsslToAttendanceSystem]
    @DeletedID INT 
AS
BEGIN
    DELETE FROM [Attendance_System].[dbo].[Department]
    WHERE [department_id] = @DeletedID;
END


