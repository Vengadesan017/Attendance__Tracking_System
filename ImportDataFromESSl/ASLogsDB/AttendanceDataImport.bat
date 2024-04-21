sqlcmd -S MSI -d Attendance_System -E -m-1 -Q "EXEC [dbo].[AttendanceDataFromASLogsToAttendanceSystem]" >> "C:\Users\User\Desktop\Project Files\Attendance_msg.txt"
