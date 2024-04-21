
USE [Attendance_System]

DROP PROCEDURE IF EXISTS [dbo].[ImportEmployeeAndDepartmentData];  
GO

CREATE PROCEDURE [dbo].[ImportEmployeeAndDepartmentData]
AS
BEGIN
	IF EXISTS (SELECT 1 FROM sys.servers WHERE name = 'DESKTOP-NVPV7F5')
	BEGIN
		SET NOCOUNT ON;

-- For
-- Employee table

		-- For Insert
		INSERT INTO [DESKTOP-JDKD7I3\SQLEXPRESS].[Attendance_System].[dbo].[Employee]
			([EmployeeCode], [employee_id], [employee_name], [Gender], [Father_name], [Mother_name], [email], [Department_id], [Designation], [DOJ], [DOR], [DOB], [Employee_type], [is_working], [Blood_group],[Address])
		SELECT
			[EmployeeCode],
			[EmployeeId],
			[EmployeeName],
			[Gender],
			[FatherName],
			[MotherName],
			[Email],
			[DepartmentId],
			[Designation],
			TRY_CONVERT(date,[DOJ]),
			TRY_CONVERT(date,[DOR]),
			TRY_CONVERT(date,[DOB]),
		    [EmployementType],
		    [Status],
		    [BLOODGROUP],
		    [PermanentAddress]
		FROM [DESKTOP-NVPV7F5].[etimetracklite1].[dbo].[Employees] 
		where EmployeeId > ISNULL((SELECT MAX(employee_id) FROM [DESKTOP-JDKD7I3\SQLEXPRESS].[Attendance_System].[dbo].[Employee]), 0)



		-- For Update         
		UPDATE A
		SET 
        [EmployeeCode] = B.[EmployeeCode],
        [employee_name] = B.[EmployeeName],
        [Gender] = B.[Gender],
        [Father_name] = B.[FatherName],
        [Mother_name] = B.[MotherName],
        [email] = B.[Email],
        [Department_id] = B.[DepartmentId],
        [Designation] = B.[Designation],
        [DOJ] =TRY_CONVERT(date, B.[DOJ]),
        [DOR] =TRY_CONVERT(date, B.[DOR]),
        [DOB] =TRY_CONVERT(date, B.[DOB]),
        [Employee_type] = B.[EmployementType],
        [is_working] = B.[Status],
        [Blood_group] = B.[BLOODGROUP],
        [Address] = B.[PermanentAddress]
		FROM 
			[DESKTOP-JDKD7I3\SQLEXPRESS].[Attendance_System].[dbo].[Employee] AS A
		INNER JOIN 
			(
				SELECT *
				FROM [DESKTOP-NVPV7F5].[etimetracklite1].[dbo].[Employees]
				WHERE 
					[Status] = 'Working'
			) B
		ON 
			A.[employee_id] = B.[EmployeeId]
		WHERE
	        A.[EmployeeCode] != B.[EmployeeCode] OR
	        A.[employee_name] != B.[EmployeeName] OR
	        A.[Gender] != B.[Gender] OR
	        A.[Father_name] != B.[FatherName] OR
	        A.[Mother_name] != B.[MotherName] OR
	        A.[email] != B.[Email] OR
	        A.[Department_id] != B.[DepartmentId] OR
	        A.[Designation] != B.[Designation] OR
	        A.[DOJ] !=TRY_CONVERT(date, B.[DOJ]) OR
	        A.[DOR] !=TRY_CONVERT(date, B.[DOR]) OR
	        A.[DOB] !=TRY_CONVERT(date, B.[DOB]) OR
	        A.[Employee_type] != B.[EmployementType] OR
	        A.[is_working] != B.[Status] OR
	        A.[Blood_group] != B.[BLOODGROUP] OR
	        A.[Address] != B.[PermanentAddress]




		-- For Delete
		DELETE FROM  [DESKTOP-JDKD7I3\SQLEXPRESS].[Attendance_System].[dbo].[Employee]
		WHERE [employee_id] NOT IN (
			SELECT [EmployeeId]
			FROM [DESKTOP-NVPV7F5].[etimetracklite1].[dbo].[Employees] 
		) 


-- For
-- Department table


		-- For Insert
		SET IDENTITY_INSERT [Attendance_System].[dbo].[Department] ON;
		INSERT INTO [DESKTOP-JDKD7I3\SQLEXPRESS].[Attendance_System].[dbo].[Department]
			([department_id], [department_name],  [user_id],[division_id])
		SELECT
			[DepartmentId],
			[DepartmentFName],
			-1,
		    -1
		FROM [DESKTOP-NVPV7F5].[etimetracklite1].[dbo].[Departments] 
		where DepartmentId > ISNULL((SELECT MAX([department_id]) FROM [DESKTOP-JDKD7I3\SQLEXPRESS].[Attendance_System].[dbo].[Department]), 0)
		SET IDENTITY_INSERT [Attendance_System].[dbo].[Department] OFF;



		-- For Update         
		UPDATE A
		SET 
        [department_name] = B.[DepartmentFName]
		FROM 
			[DESKTOP-JDKD7I3\SQLEXPRESS].[Attendance_System].[dbo].[Department] AS A
		INNER JOIN 
			(
				SELECT *
				FROM [DESKTOP-NVPV7F5].[etimetracklite1].[dbo].[Departments]
			) B
		ON 
			A.[department_id] = B.[DepartmentId]
		WHERE
	        A.[department_name] != B.[DepartmentFName]



		-- For Delete
		DELETE FROM  [DESKTOP-JDKD7I3\SQLEXPRESS].[Attendance_System].[dbo].[Department]
		WHERE [department_id] NOT IN (
			SELECT [DepartmentId]
			FROM [DESKTOP-NVPV7F5].[etimetracklite1].[dbo].[Departments] 
		) 



	END
	ELSE
		PRINT 'Linked server "DESKTOP-NVPV7F5" not found.';

END;


