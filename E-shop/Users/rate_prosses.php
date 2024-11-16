
<?php
session_start();

    include("connection.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    // Retrieve the form data
    $customerID = $_SESSION['UserID'];
    $shopID = $_Post['shopID'];
    $comment = $_POST['comment'];
    $noOfStars = $_POST['noOfStars'];

    // Insert the data into the database
    $sql = "INSERT INTO shop_rate (CustomerID, shopID, Comment, No_of_stars, Rate_date)
            VALUES (:CID, :SIDD, :Commnt, :Cstar,NOW())";

$stmt = $con->prepare($sql);

$stmt->bindParam(':CID', $customerID, PDO::PARAM_STR);
$stmt->bindParam(':SIDD', $shopID, PDO::PARAM_STR);
$stmt->bindParam(':Commnt', $comment, PDO::PARAM_STR);
$stmt->bindParam(':Cstar', $noOfStars, PDO::PARAM_STR);


if ($stmt->execute()) {
    echo "<script>alert('unable to send the request please try again.');</script>";

} 
else {
    echo "<script>alert('unable to send the request please try again.');</script>";
}

}
?>


