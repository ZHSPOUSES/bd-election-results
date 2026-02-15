<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// =============================================
// ডাটাবেস কনফিগারেশন - এখানেই দেওয়া আছে
// =============================================
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

// =============================================
// অভ্র বাংলা সাপোর্টের জন্য সেটিংস
// =============================================
$conn->set_charset("utf8mb4");
$conn->query("SET NAMES utf8mb4");
$conn->query("SET CHARACTER SET utf8mb4");
$conn->query("SET character_set_client = utf8mb4");
$conn->query("SET character_set_connection = utf8mb4");
$conn->query("SET character_set_results = utf8mb4");
$conn->query("SET collation_connection = utf8mb4_unicode_ci");

// =============================================
// ভোট রেজাল্ট যোগ করার প্রসেসিং
// =============================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_vote'])) {
    
    $seat_id = intval($_POST['seat_id']);
    $area_name = trim($_POST['area_name']);
    $area_type = trim($_POST['area_type']);
    $party1_votes = intval($_POST['party1_votes']);
    $party2_votes = intval($_POST['party2_votes']);
    $party1_id = 1;
    $party2_id = 2;
    
    if ($seat_id > 0 && !empty($area_name)) {
        
        // ইউনিকোড ফিক্স
        $area_name = $conn->real_escape_string($area_name);
        $area_type = $conn->real_escape_string($area_type);
        
        $seat_info = $conn->query("SELECT * FROM seats WHERE id = $seat_id");
        $seat_data = $seat_info->fetch_assoc();
        
        $stmt = $conn->prepare("INSERT INTO vote_results (seat_id, area_name, area_type, party1_id, party2_id, party1_votes, party2_votes) VALUES (?, ?, ?, 1, 2, ?, ?)");
        $stmt->bind_param("issii", $seat_id, $area_name, $area_type, $party1_votes, $party2_votes);
        
        if ($stmt->execute()) {
            
            // বিজয়ী নির্ধারণ
            $winner = '';
            $winner_symbol = '';
            $winner_votes = 0;
            $loser = '';
            $loser_symbol = '';
            $loser_votes = 0;
            $margin = 0;
            
            if ($party1_votes > $party2_votes) {
                $winner = 'ধানের শীষ';
                $winner_symbol = '🌾';
                $winner_votes = $party1_votes;
                $loser = 'দাড়ি পাল্লা';
                $loser_symbol = '🧔⚖️';
                $loser_votes = $party2_votes;
                $margin = $party1_votes - $party2_votes;
            } elseif ($party2_votes > $party1_votes) {
                $winner = 'দাড়ি পাল্লা';
                $winner_symbol = '🧔⚖️';
                $winner_votes = $party2_votes;
                $loser = 'ধানের শীষ';
                $loser_symbol = '🌾';
                $loser_votes = $party1_votes;
                $margin = $party2_votes - $party1_votes;
            } else {
                $winner = 'সমান';
                $winner_symbol = '🤝';
                $winner_votes = $party1_votes;
                $loser = 'সমান';
                $loser_symbol = '🤝';
                $loser_votes = $party2_votes;
                $margin = 0;
            }
            
            $success_vote = "✅ ভোট রেজাল্ট সফলভাবে যোগ হয়েছে!<br>
                            🏛️ {$seat_data['seat_name']} আসন<br>
                            📍 {$area_name} ({$area_type}) এলাকা<br>
                            🌾 ধানের শীষ: " . number_format($party1_votes) . " ভোট<br>
                            🧔⚖️ দাড়ি পাল্লা: " . number_format($party2_votes) . " ভোট<br>
                            🏆 বিজয়ী: {$winner_symbol} {$winner}";
            
        } else {
            $error_vote = "❌ ভোট রেজাল্ট যোগ হয়নি: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error_vote = "❌ আসন ও এলাকার নাম অবশ্যই দিন!";
    }
}

// =============================================
// ডাটা ফেচ করা
// =============================================

$seats_query = "SELECT * FROM seats ORDER BY seat_number ASC";
$seats_result = $conn->query($seats_query);

$results_query = "
    SELECT 
        vr.*,
        s.seat_name,
        s.district,
        p1.party_name as party1_name,
        p1.symbol as party1_symbol,
        p2.party_name as party2_name,
        p2.symbol as party2_symbol
    FROM vote_results vr
    JOIN seats s ON vr.seat_id = s.id
    JOIN parties p1 ON vr.party1_id = p1.id
    JOIN parties p2 ON vr.party2_id = p2.id
    ORDER BY s.seat_number ASC, vr.entry_date DESC
";
$results = $conn->query($results_query);

$total_query = "SELECT SUM(party1_votes) as total1, SUM(party2_votes) as total2 FROM vote_results";
$total_result = $conn->query($total_query);
$totals = $total_result->fetch_assoc();
$total_dhaner = $totals['total1'] ?? 0;
$total_dari = $totals['total2'] ?? 0;
$grand_total = $total_dhaner + $total_dari;
?>

<!DOCTYPE html>
<html>
<head>
    <title>অ্যাডমিন প্যানেল - ভোট রেজাল্ট</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            background: #f0f5fa; 
            padding: 20px;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header {
            background: #1e3c4f;
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { font-size: 32px; }
        .stats-card {
            background: rgba(255,255,255,0.1);
            padding: 15px 30px;
            border-radius: 15px;
        }
        .stats-card span { font-size: 28px; color: #ffd700; }
        
        .summary-box {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .summary-item {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            border-bottom: 5px solid;
        }
        .dhaner { border-bottom-color: #ffaa33; }
        .dari { border-bottom-color: #6b5b4a; }
        .total { border-bottom-color: #4caf50; }
        
        .form-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .form-title {
            font-size: 24px;
            color: #1e3c4f;
            margin-bottom: 25px;
            border-left: 8px solid #ff9933;
            padding-left: 20px;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid #e0e7ed;
            border-radius: 10px;
            font-size: 16px;
        }
        .form-control:focus {
            border-color: #ff9933;
            outline: none;
        }
        .btn {
            background: #ff9933;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover {
            background: #ff7e1a;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 8px solid #28a745;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 8px solid #dc3545;
        }
        
        .results-table {
            background: white;
            border-radius: 20px;
            padding: 30px;
        }
        .section-title {
            font-size: 24px;
            color: #1e3c4f;
            margin-bottom: 20px;
            border-left: 8px solid #ff9933;
            padding-left: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f8fafc;
            padding: 15px;
            text-align: left;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #eef2f4;
        }
        .seat-badge {
            background: #e9ecef;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 13px;
        }
        .area-badge {
            background: #d5e6f2;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 13px;
        }
        
        @media (max-width: 900px) {
            .summary-box { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>🗳️ অ্যাডমিন প্যানেল</h1>
                <p>ভোট রেজাল্ট যোগ করুন</p>
            </div>
            <div class="stats-card">
                <div>মোট ভোট</div>
                <span><?php echo number_format($grand_total); ?></span>
            </div>
        </div>
        
        <div class="summary-box">
            <div class="summary-item dhaner">
                <h4>🌾 ধানের শীষ</h4>
                <div style="font-size: 36px; font-weight: 900; color: #ff6b4a;"><?php echo number_format($total_dhaner); ?></div>
            </div>
            <div class="summary-item dari">
                <h4>🧔⚖️ দাড়ি পাল্লা</h4>
                <div style="font-size: 36px; font-weight: 900; color: #1a237e;"><?php echo number_format($total_dari); ?></div>
            </div>
            <div class="summary-item total">
                <h4>📊 মোট ভোট</h4>
                <div style="font-size: 36px; font-weight: 900; color: #2c3e50;"><?php echo number_format($grand_total); ?></div>
            </div>
        </div>
        
        <?php if(isset($success_vote)): ?>
            <div class="alert-success">
                <?php echo $success_vote; ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error_vote)): ?>
            <div class="alert-error">
                <?php echo $error_vote; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <h2 class="form-title">➕ নতুন ভোট রেজাল্ট যোগ করুন</h2>
            
            <form method="POST" action="">
                <div class="form-grid">
                    <div>
                        <div class="form-group">
                            <label>🏛️ আসন নির্বাচন করুন</label>
                            <select name="seat_id" class="form-control" required>
                                <option value="">-- আসন সিলেক্ট করুন --</option>
                                <?php 
                                if($seats_result && $seats_result->num_rows > 0) {
                                    $seats_result->data_seek(0);
                                    while($seat = $seats_result->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo $seat['id']; ?>">
                                        <?php echo $seat['seat_name']; ?>
                                    </option>
                                <?php 
                                    endwhile;
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>📍 এলাকার নাম</label>
                            <input type="text" name="area_name" class="form-control" 
                                   placeholder="যেমন: বিরামপুর" required>
                        </div>
                        
                        <div class="form-group">
                            <label>🏷️ এলাকার ধরন</label>
                            <select name="area_type" class="form-control">
                                <option value="উপজেলা">উপজেলা</option>
                                <option value="থানা">থানা</option>
                                <option value="পৌরসভা">পৌরসভা</option>
                                <option value="ইউনিয়ন">ইউনিয়ন</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <div class="form-group">
                            <label>🌾 ধানের শীষের ভোট</label>
                            <input type="number" name="party1_votes" class="form-control" 
                                   placeholder="যেমন: ১২৫০০" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label>🧔⚖️ দাড়ি পাল্লার ভোট</label>
                            <input type="number" name="party2_votes" class="form-control" 
                                   placeholder="যেমন: ৯৮০০" min="0" required>
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="add_vote" class="btn">
                    🚀 ভোট রেজাল্ট সাবমিট করুন
                </button>
            </form>
        </div>
        
        <div class="results-table">
            <h2 class="section-title">📊 এলাকা ভিত্তিক ভোট রেজাল্ট</h2>
            <table>
                <thead>
                    <tr>
                        <th>আসন</th>
                        <th>এলাকা</th>
                        <th>ধরন</th>
                        <th>🌾 ধানের শীষ</th>
                        <th>🧔⚖️ দাড়ি পাল্লা</th>
                        <th>বিজয়ী</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($results && $results->num_rows > 0): ?>
                        <?php while($row = $results->fetch_assoc()): 
                            $winner_text = '';
                            if($row['party1_votes'] > $row['party2_votes']) {
                                $winner_text = '🌾 ধানের শীষ';
                            } elseif($row['party2_votes'] > $row['party1_votes']) {
                                $winner_text = '🧔⚖️ দাড়ি পাল্লা';
                            } else {
                                $winner_text = '🤝 সমান';
                            }
                        ?>
                            <tr>
                                <td><span class="seat-badge"><?php echo $row['seat_name']; ?></span></td>
                                <td><strong><?php echo htmlspecialchars($row['area_name']); ?></strong></td>
                                <td><span class="area-badge"><?php echo $row['area_type']; ?></span></td>
                                <td style="color: #b85e00; font-weight: 700;"><?php echo number_format($row['party1_votes']); ?></td>
                                <td style="color: #1a237e; font-weight: 700;"><?php echo number_format($row['party2_votes']); ?></td>
                                <td><?php echo $winner_text; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px;">
                                <span style="font-size: 48px;">📭</span>
                                <h3 style="color: #5e7a8c; margin-top: 20px;">কোনো ভোট রেজাল্ট নেই</h3>
                                <p style="color: #8a9aa8; margin-top: 10px;">রেজাল্ট যোগ করুন</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <p><a href="index.php" style="color: #ff9933; text-decoration: none; font-weight: 600;" target="_blank">
                🏠 পাবলিক পেজ দেখুন →
            </a></p>
        </div>
    </div>
</body>
</html>