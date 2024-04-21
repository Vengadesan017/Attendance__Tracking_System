USE [master]
GO

Create DATABASE [ASLogs]

GO 

USE [ASLogs]

GO 

-- Table structure for table AttendanceLogs
CREATE TABLE [dbo].[AttendanceLogs] (
  [a_id] BIGINT NOT NULL IDENTITY(2,1),
    [OperationType] int NOT NULL,
    [essl_id] int NOT NULL,
  [employee_id] int NULL,
  [a_date] datetime NULL,
  [Shift_id] INT NULL,
  [Attendance] NVARCHAR(255) NULL,
  [Status_code] NVARCHAR(255) NULL,  
  [in_time] NVARCHAR(255) NULL,
  [out_time] NVARCHAR(255) NULL


  CONSTRAINT [PK_AttendanceLogs] PRIMARY KEY CLUSTERED ([a_id] ASC)
)

-- Table structure for table EmployeeLogs
CREATE TABLE [dbo].[EmployeeLogs] (
    [e_id] BIGINT NOT NULL IDENTITY(2,1),
    [OperationType] int NOT NULL,    
  [EmployeeCode] NVARCHAR(50) NULL,
  [employee_id] INT NOT NULL,
  [employee_name] NVARCHAR(50) NULL,
  [Gender] NVARCHAR(255) NULL,
  [Father_name] NVARCHAR(255) NULL,
  [Mother_name] NVARCHAR(255) NULL,
  [email] NVARCHAR(255) NULL,
  [Department_id] INT NULL,    
  [Designation] NVARCHAR(255) NULL,  
  [DOJ] DATETIME NULL,
  [DOR] DATETIME NULL,
  [DOB] DATETIME NULL,
  [Employee_type] NVARCHAR(255)  NULL, 
  [is_working] VARCHAR(255)  NULL,    
  [Blood_group] NVARCHAR(255) NULL,
  [Address] NVARCHAR(255) NULL,
  CONSTRAINT [PK_EmployeeLogs] PRIMARY KEY CLUSTERED ([e_id] ASC)
)

CREATE TABLE [dbo].[DepartmentLogs] (
  [d_id] BIGINT NOT NULL IDENTITY(2,1),    
    [OperationType] int NOT NULL,   
  [department_id] INT NOT NULL,    
  [department_name] NVARCHAR(100) NULL,
  CONSTRAINT [PK_DepartmentLogs] PRIMARY KEY CLUSTERED ([d_id] ASC)
)


CREATE TABLE ErrorLog (
    ErrorId INT IDENTITY(1,1) PRIMARY KEY,
    ErrorDateTime DATETIME DEFAULT GETDATE(),
    WhereFrom NVARCHAR(100),
    AffectedRows NVARCHAR(255),
    ErrorMessage NVARCHAR(255),
    ErrorSeverity TINYINT,
    ErrorState TINYINT
);