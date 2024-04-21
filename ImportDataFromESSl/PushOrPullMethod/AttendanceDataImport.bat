sqlcmd -S MSI -d Attendance_System -E -Q "EXEC [dbo].[ImportAttendanceData]" >> "C:\Users\User\Desktop\Manual Import\Attendance_msg.txt"
