<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// তোমার হোস্টিং তথ্য
$host = 'sql111.infinityfree.com';
$user = 'if0_38014675';
$pass = 'IVd5oLza1vyxc';
$db   = 'if0_38014675_app';

// কানেকশন তৈরি
$conn = new mysqli($host, $user, $pass, $db);

// কানেকশন চেক
if ($conn->connect_error) {
    die("❌ সংযোগ ব্যর্থ: " . $conn->connect_error);
}

--=============================================
-- বাংলা সাপোর্টের জন্য গুরুত্বপূর্ণ সেটিংস
--=============================================
$conn->set_charset("utf8mb4");
$conn->query("SET NAMES utf8mb4");
$conn->query("SET CHARACTER SET utf8mb4");
$conn->query("SET character_set_client = utf8mb4");
$conn->query("SET character_set_connection = utf8mb4");
$conn->query("SET character_set_results = utf8mb4");
$conn->query("SET collation_connection = utf8mb4_unicode_ci");
$conn->query("SET collation_database = utf8mb4_unicode_ci");
$conn->query("SET collation_server = utf8mb4_unicode_ci");

// ✅ সংযোগ সফল
// echo "✅ ডাটাবেস সংযোগ সফল হয়েছে!";
?>