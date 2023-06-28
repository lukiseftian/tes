<?php
class Employee{
// Connection
private $conn;
// Table
private $db_table = "Employee";
// Columns
public $id;
public $name;
public $alamat;
public $umur;
public $jenisusaha;
public $created;
// Db connection
    public function __construct($db){
    $this->conn = $db;
}
// GET ALL
public function getEmployees(){
    $sqlQuery = "SELECT id, name, alamat, umur, jenisusaha, created FROM "
. $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
}
// CREATE
    public function createEmployee(){
    $sqlQuery = "INSERT INTO
    ". $this->db_table ."
        SET
        name = :name,
        alamat = :alamat,
        umur = :umur,
        jenisusaha = :jenisusaha,
        created = :created";
$stmt = $this->conn->prepare($sqlQuery);

// sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->alamat=htmlspecialchars(strip_tags($this->alamat));
    $this->umur=htmlspecialchars(strip_tags($this->umur));
    $this->jenisusaha=htmlspecialchars(strip_tags($this->jenisusaha));
    $this->created=htmlspecialchars(strip_tags($this->created));

// bind data
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":alamat", $this->alamat);
    $stmt->bindParam(":umur", $this->umur);
    $stmt->bindParam(":jenisusaha", $this->jenisusaha);
    $stmt->bindParam(":created", $this->created);
        if($stmt->execute()){
            return true;
        }
    return false;
    }

// READ single
        public function getSingleEmployee(){
    $sqlQuery = "SELECT id, name, alamat, umur, jenisusaha, created FROM ". $this->db_table ." WHERE id = ? LIMIT 0,1";

    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
    $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->name = $dataRow['name'];
    $this->alamat = $dataRow['alamat'];
    $this->umur = $dataRow['umur'];
    $this->jenisusaha = $dataRow['jenisusaha'];
    $this->created = $dataRow['created'];
}
// UPDATE

public function updateEmployee(){
$sqlQuery = "UPDATE
". $this->db_table ."
            SET
            name = :name,
            alamat = :alamat,
            umur = :umur,
            jenisusaha = :jenisusaha,
            created = :created
            WHERE
            id = :id";

    $stmt = $this->conn->prepare($sqlQuery);
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->alamat=htmlspecialchars(strip_tags($this->alamat));
    $this->umur=htmlspecialchars(strip_tags($this->umur));
    $this->jenisusaha=htmlspecialchars(strip_tags($this->jenisusaha));
    $this->created=htmlspecialchars(strip_tags($this->created));
    $this->id=htmlspecialchars(strip_tags($this->id));
// bind data

    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":alamat", $this->alamat);
    $stmt->bindParam(":umur", $this->umur);
    $stmt->bindParam(":jenisusaha", $this->jenisusaha);
    $stmt->bindParam(":created", $this->created);
    $stmt->bindParam(":id", $this->id);
        if($stmt->execute()){
            return true;
    }
        return false;
    }
// DELETE

    function deleteEmployee(){
    $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
    $stmt = $this->conn->prepare($sqlQuery);
    $this->id=htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->id);
        if($stmt->execute()){
            return true;
            }
        return false;
        }
    }
?>