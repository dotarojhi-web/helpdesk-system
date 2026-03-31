<?php

// admin_logs.php

// Connecting to the database
include('db_connection.php');

// Pagination variables
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Getting the total number of logs
$total_logs_query = "SELECT COUNT(*) FROM audit_logs";
$total_logs_result = $db->query($total_logs_query);
$total_logs = $total_logs_result->fetch_row()[0];

// Fetching logs
$logs_query = "SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $db->prepare($logs_query);
$stmt->bind_param('ii', $limit, $offset);
$stmt->execute();
$logs_result = $stmt->get_result();

// Calculating total pages
$total_pages = ceil($total_logs / $limit);

// HTML Output
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logs</title>
</head>
<body>
    <h1>System Audit Trails</h1>
    <table>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Timestamp</th>
        </tr>
        <?php while ($log = $logs_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($log['user']); ?></td>
            <td><?php echo htmlspecialchars($log['action']); ?></td>
            <td><?php echo htmlspecialchars($log['created_at']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div>
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>
        Page <?php echo $page; ?> of <?php echo $total_pages; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</body>
</html>
