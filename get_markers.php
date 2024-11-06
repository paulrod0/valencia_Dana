<?php
header('Content-Type: application/javascript');
include 'db.php';

$sql = "SELECT * FROM markers";
$result = $conn->query($sql);

$markers = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $markers[] = $row;
    }
}
$conn->close();
?>

var markers = <?php echo json_encode($markers); ?>;
