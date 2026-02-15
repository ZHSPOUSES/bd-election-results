<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// =============================================
// ডাটাবেস কনফিগারেশন
// =============================================
$host = 'sql111.infinityfree.com';
$user = 'if0_38014675';
$pass = 'IVd5oLza1vyxc';
$db   = 'if0_38014675_app';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ সংযোগ ব্যর্থ: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
$conn->query("SET NAMES utf8mb4");
$conn->query("SET CHARACTER SET utf8mb4");

// =============================================
// ডাটা ফেচ করা
// =============================================

// দিনাজপুর-১ এর ফলাফল
$seat1_query = "
    SELECT 
        vr.*,
        s.seat_name,
        p1.party_name as party1_name,
        p1.symbol as party1_symbol,
        p2.party_name as party2_name,
        p2.symbol as party2_symbol
    FROM vote_results vr
    JOIN seats s ON vr.seat_id = s.id
    JOIN parties p1 ON vr.party1_id = p1.id
    JOIN parties p2 ON vr.party2_id = p2.id
    WHERE s.id = 1
    ORDER BY vr.entry_date DESC
";
$seat1_results = $conn->query($seat1_query);

// দিনাজপুর-৬ এর ফলাফল
$seat6_query = "
    SELECT 
        vr.*,
        s.seat_name,
        p1.party_name as party1_name,
        p1.symbol as party1_symbol,
        p2.party_name as party2_name,
        p2.symbol as party2_symbol
    FROM vote_results vr
    JOIN seats s ON vr.seat_id = s.id
    JOIN parties p1 ON vr.party1_id = p1.id
    JOIN parties p2 ON vr.party2_id = p2.id
    WHERE s.id = 6
    ORDER BY vr.entry_date DESC
";
$seat6_results = $conn->query($seat6_query);

// মোট ভোট গণনা
$total_query = "SELECT 
    SUM(CASE WHEN seat_id = 1 THEN party1_votes ELSE 0 END) as seat1_dhaner,
    SUM(CASE WHEN seat_id = 1 THEN party2_votes ELSE 0 END) as seat1_dari,
    SUM(CASE WHEN seat_id = 6 THEN party1_votes ELSE 0 END) as seat6_dhaner,
    SUM(CASE WHEN seat_id = 6 THEN party2_votes ELSE 0 END) as seat6_dari
FROM vote_results";
$total_result = $conn->query($total_query);
$totals = $total_result->fetch_assoc();

// আসন ভিত্তিক বিজয়ী গণনা
$winner_query = "
    SELECT 
        seat_id,
        COUNT(CASE WHEN party1_votes > party2_votes THEN 1 END) as dhaner_win,
        COUNT(CASE WHEN party2_votes > party1_votes THEN 1 END) as dari_win
    FROM vote_results
    WHERE seat_id IN (1,6)
    GROUP BY seat_id
";
$winner_result = $conn->query($winner_query);
$winners = [];
while($row = $winner_result->fetch_assoc()) {
    $winners[$row['seat_id']] = $row;
}

// =============================================
// স্ক্রিনশট ডাটা (প্রিন্টেড বাই মনতাজার)
// =============================================
$screenshots = [
    [
        'id' => 1,
        'title' => 'বিরামপুর কেন্দ্র-১',
        'image' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=400',
        'time' => '১০:২৫ এএম',
        'votes' => '২১৬০ | ২৭০',
        'winner' => '🌾 ধানের শীষ'
    ],
    [
        'id' => 2,
        'title' => 'হেলাপুর (নবরাজগঞ্জ)',
        'image' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=400',
        'time' => '১০:১৫ এএম',
        'votes' => '৬০০ | ২৪০০',
        'winner' => '🧔⚖️ দাড়ি পাল্লা'
    ],
    [
        'id' => 3,
        'title' => 'মহিহারা বাজার',
        'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=400',
        'time' => '১০:০৫ এএম',
        'votes' => '৩০০০ | ৬০০',
        'winner' => '🌾 ধানের শীষ'
    ],
    [
        'id' => 4,
        'title' => 'জালালপুর',
        'image' => 'https://images.unsplash.com/photo-1560169897-fc0cdbdfa4d5?w=400',
        'time' => '০৯:৫৫ এএম',
        'votes' => '১৫৩৬ | ৯',
        'winner' => '🌾 ধানের শীষ'
    ],
    [
        'id' => 5,
        'title' => 'চিতলগড় কলেজ',
        'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400',
        'time' => '০৯:৪৫ এএম',
        'votes' => '২০১৮ | ২৮৯৭',
        'winner' => '🧔⚖️ দাড়ি পাল্লা'
    ],
    [
        'id' => 6,
        'title' => 'হিলি চকচকা',
        'image' => 'https://images.unsplash.com/photo-1507525425514-82319ac5b7a9?w=400',
        'time' => '০৯:৩৫ এএম',
        'votes' => '৭০০ | ১১০১',
        'winner' => '🧔⚖️ দাড়ি পাল্লা'
    ],
    [
        'id' => 7,
        'title' => 'কাটলা ডিগ্রি কলেজ',
        'image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=400',
        'time' => '০৯:২৫ এএম',
        'votes' => '১৭১৪ | ১৪১৩',
        'winner' => '🌾 ধানের শীষ'
    ],
    [
        'id' => 8,
        'title' => 'ঘোড়াঘাট দাখিল মাদ্রাসা',
        'image' => 'https://images.unsplash.com/photo-1596492784531-6e6eb5ea9993?w=400',
        'time' => '০৯:১৫ এএম',
        'votes' => '১৩৪০ | ১৩৩৪',
        'winner' => '🌾 ধানের শীষ'
    ]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>🗳️ দিনাজপুর আসন ভিত্তিক ফলাফল ২০২৬ | লাইভ আপডেট</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5, user-scalable=yes, viewport-fit=cover">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="refresh" content="30">
    <meta name="theme-color" content="#1e3c4f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <!-- Font Awesome 6 (মোবাইল অপ্টিমাইজড) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Swiper CSS (মোবাইল স্লাইডার) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }
        
        body {
            background: linear-gradient(145deg, #0a1922, #0e1c26);
            font-family: 'Segoe UI', 'Nikosh', 'SolaimanLipi', 'Hind Siliguri', 'Arial', sans-serif;
            padding: 15px 12px;
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        /* অ্যানিমেটেড পার্টিকেল ব্যাকগ্রাউন্ড */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(255, 153, 51, 0.3);
            border-radius: 50%;
            animation: floatParticle 15s infinite linear;
        }
        
        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) translateX(0);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% {
                transform: translateY(-100px) translateX(100px);
                opacity: 0;
            }
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }
        
        /* ========== মোবাইল লাইভ ব্যাজ ========== */
        .mobile-live-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 12px 18px;
            border-radius: 60px;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            animation: slideDown 0.8s ease;
        }
        
        .live-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ff3b3b;
            padding: 6px 16px;
            border-radius: 50px;
            animation: pulse 1.2s infinite;
        }
        
        .live-dot {
            width: 12px;
            height: 12px;
            background: white;
            border-radius: 50%;
            animation: blink 1s infinite;
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }
        
        .date-badge {
            color: white;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        /* ========== হেডার (মোবাইল) ========== */
        .header {
            text-align: center;
            margin-bottom: 25px;
            animation: fadeInScale 1s ease;
        }
        
        @keyframes fadeInScale {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .header h1 {
            font-size: 28px;
            color: white;
            text-shadow: 0 5px 15px rgba(0,0,0,0.5);
            margin-bottom: 10px;
            font-weight: 900;
            letter-spacing: 1px;
            line-height: 1.3;
        }
        
        .header p {
            font-size: 16px;
            color: #ffd700;
            font-weight: 600;
            background: rgba(0,0,0,0.4);
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,215,0,0.3);
        }
        
        /* ========== প্রিন্টেড বাই (মোবাইল) ========== */
        .printed-by-mobile {
            background: linear-gradient(145deg, #2c3e50, #1a2a36);
            color: #ffd700;
            padding: 12px 20px;
            border-radius: 60px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 2px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,215,0,0.3);
            animation: glowPulse 2s infinite;
        }
        
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 5px 20px rgba(255,215,0,0.2); }
            50% { box-shadow: 0 5px 30px rgba(255,215,0,0.5); }
        }
        
        /* ========== মোট ভোট কার্ড (মোবাইল) ========== */
        .total-vote-card {
            background: linear-gradient(145deg, #1e3c4f, #0f2a36);
            color: white;
            padding: 25px 20px;
            border-radius: 30px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.1);
            animation: slideUp 0.8s ease;
            position: relative;
            overflow: hidden;
        }
        
        .total-vote-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,153,51,0.2) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        .total-label {
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 2;
        }
        
        .total-number {
            font-size: 42px;
            font-weight: 900;
            color: #ffd700;
            text-shadow: 0 0 20px rgba(255,215,0,0.5);
            position: relative;
            z-index: 2;
            animation: countUp 1.5s ease-out;
        }
        
        /* ========== আসন কার্ড (মোবাইল) ========== */
        .seat-cards-mobile {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .seat-card-mobile {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            animation: slideInCard 0.8s ease;
            transition: all 0.4s;
        }
        
        .seat-card-mobile:active {
            transform: scale(0.98);
        }
        
        .seat-header-mobile {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .seat-title-mobile {
            font-size: 24px;
            font-weight: 800;
            color: #1e3c4f;
        }
        
        .seat-badge-mobile {
            background: #ff9933;
            color: white;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
        }
        
        .party-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 20px;
            transition: all 0.3s;
        }
        
        .party-row:active {
            transform: scale(0.99);
        }
        
        .party-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .party-icon-mobile {
            font-size: 32px;
        }
        
        .party-name-mobile {
            font-size: 18px;
            font-weight: 700;
        }
        
        .party-votes-mobile {
            font-size: 28px;
            font-weight: 900;
        }
        
        .seat-stats-mobile {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px dashed #e0e7ed;
        }
        
        .stat-item-mobile {
            text-align: center;
        }
        
        .stat-label-mobile {
            font-size: 14px;
            color: #5e7a8c;
            margin-bottom: 5px;
        }
        
        .stat-value-mobile {
            font-size: 22px;
            font-weight: 800;
        }
        
        /* ========== ট্যাব মেনু (মোবাইল) ========== */
        .tab-menu {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            overflow-x: auto;
            padding-bottom: 5px;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }
        
        .tab-menu::-webkit-scrollbar {
            display: none;
        }
        
        .tab-item {
            flex: 0 0 auto;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 12px 25px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
        }
        
        .tab-item.active {
            background: #ff9933;
            border-color: #ff9933;
            box-shadow: 0 5px 20px rgba(255,153,51,0.4);
        }
        
        /* ========== ফলাফল তালিকা (মোবাইল) ========== */
        .results-list {
            background: white;
            border-radius: 30px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            animation: slideUp 0.8s ease;
        }
        
        .list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .list-title {
            font-size: 20px;
            font-weight: 800;
            color: #1e3c4f;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .count-badge {
            background: #ff9933;
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 14px;
        }
        
        .area-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eef2f4;
            animation: fadeInRow 0.5s ease forwards;
            opacity: 0;
            animation-delay: calc(var(--row-index) * 0.05s);
        }
        
        .area-info {
            flex: 1;
        }
        
        .area-name {
            font-size: 16px;
            font-weight: 700;
            color: #1e3c4f;
            margin-bottom: 5px;
        }
        
        .area-seat {
            font-size: 13px;
            color: #5e7a8c;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .vote-numbers {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .vote-dhaner {
            color: #b85e00;
            font-weight: 800;
            font-size: 18px;
        }
        
        .vote-dari {
            color: #1a237e;
            font-weight: 800;
            font-size: 18px;
        }
        
        .winner-tag {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }
        
        /* ========== স্ক্রিনশট স্লাইডার (মোবাইল) ========== */
        .screenshot-slider {
            background: white;
            border-radius: 30px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .slider-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .swiper {
            width: 100%;
            padding-bottom: 30px;
        }
        
        .swiper-slide {
            background: #fafcfd;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            transition: all 0.4s;
            height: auto;
        }
        
        .swiper-slide:active {
            transform: scale(0.98);
        }
        
        .slide-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 4px solid #ff9933;
        }
        
        .slide-content {
            padding: 15px;
        }
        
        .slide-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e3c4f;
            margin-bottom: 8px;
        }
        
        .slide-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            color: #5e7a8c;
            font-size: 13px;
        }
        
        .slide-votes {
            font-size: 16px;
            font-weight: 800;
            color: #ff6b4a;
        }
        
        .slide-winner {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            margin-top: 8px;
        }
        
        .printed-by-tag {
            margin-top: 10px;
            font-size: 11px;
            color: #95a5a6;
            text-align: right;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 5px;
        }
        
        /* ========== ফুটার (মোবাইল) ========== */
        .footer-mobile {
            text-align: center;
            padding: 25px 15px;
            color: rgba(255,255,255,0.7);
            font-size: 14px;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 20px;
        }
        
        /* ========== অ্যানিমেশন ক্লাস ========== */
        @keyframes slideUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideDown {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInCard {
            0% { opacity: 0; transform: translateX(-30px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes fadeInRow {
            0% { opacity: 0; transform: translateX(-20px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes countUp {
            0% { opacity: 0; transform: scale(0.5); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* ========== টাচ অপ্টিমাইজেশন ========== */
        button, 
        .seat-card-mobile, 
        .tab-item, 
        .swiper-slide {
            cursor: pointer;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            user-select: none;
        }
        
        /* ========== ল্যান্ডস্কেপ মোড ========== */
        @media (orientation: landscape) and (max-height: 500px) {
            body {
                padding: 10px;
            }
            
            .seat-cards-mobile {
                flex-direction: row;
            }
            
            .seat-card-mobile {
                flex: 1;
            }
        }
        
        /* ========== ছোট স্ক্রিন (৩২০px) ========== */
        @media (max-width: 360px) {
            .header h1 {
                font-size: 22px;
            }
            
            .total-number {
                font-size: 32px;
            }
            
            .party-votes-mobile {
                font-size: 22px;
            }
            
            .vote-numbers {
                gap: 8px;
            }
            
            .vote-dhaner, .vote-dari {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- পার্টিকেল ব্যাকগ্রাউন্ড -->
    <div class="particles">
        <?php for($i = 0; $i < 30; $i++): ?>
        <div class="particle" style="
            left: <?php echo rand(0, 100); ?>%;
            width: <?php echo rand(4, 12); ?>px;
            height: <?php echo rand(4, 12); ?>px;
            animation-delay: <?php echo rand(0, 15); ?>s;
            animation-duration: <?php echo rand(10, 25); ?>s;
            background: <?php echo rand(0, 1) ? 'rgba(255,153,51,0.3)' : 'rgba(255,215,0,0.3)'; ?>;
        "></div>
        <?php endfor; ?>
    </div>
    
    <div class="container">
        <!-- মোবাইল লাইভ বার -->
        <div class="mobile-live-bar">
            <div class="live-indicator">
                <span class="live-dot"></span>
                <span style="color: white; font-weight: 700;">LIVE</span>
            </div>
            <div class="date-badge">
                <i class="far fa-calendar-alt"></i>
                <?php echo date('d M Y'); ?>
            </div>
        </div>
        
        <!-- হেডার -->
        <div class="header">
            <h1>
                🗳️ দিনাজপুর<br>আসন ভিত্তিক ফলাফল
            </h1>
            <p>ধানের শীষ vs দাড়ি পাল্লা</p>
        </div>
        
        <!-- প্রিন্টেড বাই মনতাজার (মোবাইল) -->
        <div class="printed-by-mobile">
            <i class="fas fa-print"></i>
            <span>PRINTED BY MONTAZAR</span>
            <i class="fas fa-copyright"></i>
        </div>
        
        <!-- মোট ভোট কার্ড -->
        <div class="total-vote-card">
            <span class="total-label">
                <i class="fas fa-vote-yea"></i>
                মোট ভোট
            </span>
            <span class="total-number">
                <?php 
                $total_all = ($totals['seat1_dhaner'] ?? 0) + ($totals['seat1_dari'] ?? 0) + 
                            ($totals['seat6_dhaner'] ?? 0) + ($totals['seat6_dari'] ?? 0);
                echo number_format($total_all);
                ?>
            </span>
        </div>
        
        <!-- আসন কার্ড (মোবাইল) -->
        <div class="seat-cards-mobile">
       
            <!-- দিনাজপুর-৬ -->
            <div class="seat-card-mobile" onclick="void(0)">
                <div class="seat-header-mobile">
                    <span class="seat-title-mobile">🏛️ দিনাজপুর-৬</span>
                    <span class="seat-badge-mobile">দিনাজপুর </span>
                </div>
                
                <div class="party-row" style="background: #fff9f0;">
                    <div class="party-info">
                        <span class="party-icon-mobile">🌾</span>
                        <span class="party-name-mobile" style="color: #b85e00;">ধানের শীষ</span>
                    </div>
                    <span class="party-votes-mobile" style="color: #ff6b4a;">
                        <?php echo number_format($totals['seat6_dhaner'] ?? 0); ?>
                    </span>
                </div>
                
                <div class="party-row" style="background: #f5f3ff;">
                    <div class="party-info">
                        <span class="party-icon-mobile">⚖️</span>
                        <span class="party-name-mobile" style="color: #1a237e;">দাড়ি পাল্লা</span>
                    </div>
                    <span class="party-votes-mobile" style="color: #1a237e;">
                        <?php echo number_format($totals['seat6_dari'] ?? 0); ?>
                    </span>
                </div>
                
                <div class="seat-stats-mobile">
                    <div class="stat-item-mobile">
                        <div class="stat-label-mobile">🌾 বিজয়ী</div>
                        <div class="stat-value-mobile" style="color: #b85e00;">
                            <?php echo $winners[6]['dhaner_win'] ?? 0; ?>
                        </div>
                    </div>
                    <div class="stat-item-mobile">
                        <div class="stat-label-mobile">⚖️ বিজয়ী</div>
                        <div class="stat-value-mobile" style="color: #1a237e;">
                            <?php echo $winners[6]['dari_win'] ?? 0; ?>
                        </div>
                    </div>
                    <div class="stat-item-mobile">
                        <div class="stat-label-mobile">মোট কেন্দ্র</div>
                        <div class="stat-value-mobile" style="color: #2c3e50;">
                            <?php echo ($winners[6]['dhaner_win'] ?? 0) + ($winners[6]['dari_win'] ?? 0); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ট্যাব মেনু -->
        <div class="tab-menu">
            <div class="tab-item active" onclick="showTab('results')">
                <i class="fas fa-list"></i> ফলাফল
            </div>
            <div class="tab-item" onclick="showTab('screenshots')">
                <i class="fas fa-camera"></i> স্ক্রিনশট
            </div>
            <div class="tab-item" onclick="showTab('stats')">
                <i class="fas fa-chart-pie"></i> পরিসংখ্যান
            </div>
        </div>
        
        <!-- ফলাফল তালিকা (ট্যাব ১) -->
        <div id="results-tab" class="results-list" style="display: block;">
            <div class="list-header">
                <div class="list-title">
                    <i class="fas fa-location-dot" style="color: #ff9933;"></i>
                    এলাকা ভিত্তিক ফলাফল
                </div>
                <span class="count-badge">
                    <?php 
                    $total_centers = ($seat1_results ? $seat1_results->num_rows : 0) + 
                                    ($seat6_results ? $seat6_results->num_rows : 0);
                    echo $total_centers; 
                    ?> টি কেন্দ্র
                </span>
            </div>
            
            <div style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
                <?php 
                $row_index = 0;
                
                // দিনাজপুর-১
                if($seat1_results && $seat1_results->num_rows > 0):
                    $seat1_results->data_seek(0);
                    while($row = $seat1_results->fetch_assoc()): 
                        $winner_class = '';
                        $winner_text = '';
                        
                        if($row['party1_votes'] > $row['party2_votes']) {
                            $winner_class = 'winner-dhaner';
                            $winner_text = '🌾';
                        } elseif($row['party2_votes'] > $row['party1_votes']) {
                            $winner_class = 'winner-dari';
                            $winner_text = '⚖️';
                        } else {
                            $winner_class = '';
                            $winner_text = '🤝';
                        }
                ?>
                    <div class="area-item" style="--row-index: <?php echo $row_index++; ?>;">
                        <div class="area-info">
                            <div class="area-name"><?php echo htmlspecialchars($row['area_name']); ?></div>
                            <div class="area-seat">
                                <span class="seat-badge" style="background: #e9ecef; padding: 3px 10px; border-radius: 50px; font-size: 11px;">
                                    দিনাজপুর-১
                                </span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div class="vote-numbers">
                                <span class="vote-dhaner"><?php echo number_format($row['party1_votes']); ?></span>
                                <span style="color: #95a5a6;">|</span>
                                <span class="vote-dari"><?php echo number_format($row['party2_votes']); ?></span>
                            </div>
                            <span class="winner-tag" style="background: <?php echo $row['party1_votes'] > $row['party2_votes'] ? '#fff3e0' : ($row['party2_votes'] > $row['party1_votes'] ? '#e8eaf6' : '#f8f9fa'); ?>; color: <?php echo $row['party1_votes'] > $row['party2_votes'] ? '#b85e00' : ($row['party2_votes'] > $row['party1_votes'] ? '#1a237e' : '#7f8c8d'); ?>;">
                                <?php echo $winner_text; ?>
                            </span>
                        </div>
                    </div>
                <?php 
                    endwhile;
                endif;
                
                // দিনাজপুর-৬
                if($seat6_results && $seat6_results->num_rows > 0):
                    $seat6_results->data_seek(0);
                    while($row = $seat6_results->fetch_assoc()): 
                        $winner_class = '';
                        $winner_text = '';
                        
                        if($row['party1_votes'] > $row['party2_votes']) {
                            $winner_class = 'winner-dhaner';
                            $winner_text = '🌾';
                        } elseif($row['party2_votes'] > $row['party1_votes']) {
                            $winner_class = 'winner-dari';
                            $winner_text = '⚖️';
                        } else {
                            $winner_class = '';
                            $winner_text = '🤝';
                        }
                ?>
                    <div class="area-item" style="--row-index: <?php echo $row_index++; ?>;">
                        <div class="area-info">
                            <div class="area-name"><?php echo htmlspecialchars($row['area_name']); ?></div>
                            <div class="area-seat">
                                <span class="seat-badge" style="background: #e9ecef; padding: 3px 10px; border-radius: 50px; font-size: 11px;">
                                    দিনাজপুর-৬
                                </span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div class="vote-numbers">
                                <span class="vote-dhaner"><?php echo number_format($row['party1_votes']); ?></span>
                                <span style="color: #95a5a6;">|</span>
                                <span class="vote-dari"><?php echo number_format($row['party2_votes']); ?></span>
                            </div>
                            <span class="winner-tag" style="background: <?php echo $row['party1_votes'] > $row['party2_votes'] ? '#fff3e0' : ($row['party2_votes'] > $row['party1_votes'] ? '#e8eaf6' : '#f8f9fa'); ?>; color: <?php echo $row['party1_votes'] > $row['party2_votes'] ? '#b85e00' : ($row['party2_votes'] > $row['party1_votes'] ? '#1a237e' : '#7f8c8d'); ?>;">
                                <?php echo $winner_text; ?>
                            </span>
                        </div>
                    </div>
                <?php 
                    endwhile;
                endif;
                
                if($row_index == 0):
                ?>
                    <div style="text-align: center; padding: 40px 20px;">
                        <span style="font-size: 48px;">📭</span>
                        <p style="color: #5e7a8c; margin-top: 15px;">কোনো ভোট রেজাল্ট নেই</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- স্ক্রিনশট স্লাইডার (ট্যাব ২) -->
        <div id="screenshots-tab" class="screenshot-slider" style="display: none;">
            <div class="slider-header">
                <div class="list-title">
                    <i class="fas fa-camera" style="color: #ff9933;"></i>
                    প্রমাণিত ফলাফল
                </div>
                <span class="count-badge">
                    <?php echo count($screenshots); ?> টি স্ক্রিনশট
                </span>
            </div>
            
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach($screenshots as $ss): ?>
                    <div class="swiper-slide">
                        <img src="<?php echo $ss['image']; ?>" alt="<?php echo $ss['title']; ?>" class="slide-image" loading="lazy">
                        <div class="slide-content">
                            <div class="slide-title">
                                <i class="fas fa-location-dot" style="color: #ff9933;"></i>
                                <?php echo $ss['title']; ?>
                            </div>
                            <div class="slide-meta">
                                <span><i class="far fa-clock"></i> <?php echo $ss['time']; ?></span>
                                <span class="slide-votes"><?php echo $ss['votes']; ?></span>
                            </div>
                            <span class="slide-winner" style="background: <?php echo strpos($ss['winner'], 'ধানের') !== false ? '#fff3e0' : '#e8eaf6'; ?>; color: <?php echo strpos($ss['winner'], 'ধানের') !== false ? '#b85e00' : '#1a237e'; ?>;">
                                <i class="fas fa-trophy"></i> <?php echo $ss['winner']; ?>
                            </span>
                            <div class="printed-by-tag">
                                <i class="fas fa-print"></i> Printed by Montazar
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        
        <!-- পরিসংখ্যান ট্যাব (ট্যাব ৩) -->
        <div id="stats-tab" class="results-list" style="display: none;">
            <div class="list-header">
                <div class="list-title">
                    <i class="fas fa-chart-pie" style="color: #ff9933;"></i>
                    পরিসংখ্যান
                </div>
            </div>
            
            <div style="padding: 10px 0;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                    <div style="background: linear-gradient(145deg, #fff3e0, #ffe4bc); padding: 20px; border-radius: 20px; text-align: center;">
                        <span style="font-size: 32px;">🌾</span>
                        <h4 style="color: #b85e00; margin: 10px 0; font-size: 18px;">ধানের শীষ</h4>
                        <p style="font-size: 28px; font-weight: 900; color: #ff6b4a;">
                            <?php 
                            $total_dhaner_all = ($totals['seat1_dhaner'] ?? 0) + ($totals['seat6_dhaner'] ?? 0);
                            echo number_format($total_dhaner_all); 
                            ?>
                        </p>
                        <p style="color: #5e7a8c; font-size: 14px;">মোট ভোট</p>
                    </div>
                    
                    <div style="background: linear-gradient(145deg, #e8eaf6, #d1d9ff); padding: 20px; border-radius: 20px; text-align: center;">
                        <span style="font-size: 32px;">🧔⚖️</span>
                        <h4 style="color: #1a237e; margin: 10px 0; font-size: 18px;">দাড়ি পাল্লা</h4>
                        <p style="font-size: 28px; font-weight: 900; color: #1a237e;">
                            <?php 
                            $total_dari_all = ($totals['seat1_dari'] ?? 0) + ($totals['seat6_dari'] ?? 0);
                            echo number_format($total_dari_all); 
                            ?>
                        </p>
                        <p style="color: #5e7a8c; font-size: 14px;">মোট ভোট</p>
                    </div>
                </div>
                
                <div style="background: #f8fafc; border-radius: 20px; padding: 20px;">
                    <h4 style="color: #1e3c4f; margin-bottom: 15px; font-size: 18px;">🏆 আসন ভিত্তিক বিজয়ী</h4>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-weight: 600;">দিনাজপুর-১</span>
                        <div style="display: flex; gap: 10px;">
                            <span style="background: #fff3e0; color: #b85e00; padding: 5px 12px; border-radius: 50px; font-size: 13px; font-weight: 700;">
                                🌾 <?php echo $winners[1]['dhaner_win'] ?? 0; ?>
                            </span>
                            <span style="background: #e8eaf6; color: #1a237e; padding: 5px 12px; border-radius: 50px; font-size: 13px; font-weight: 700;">
                                🧔⚖️ <?php echo $winners[1]['dari_win'] ?? 0; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 600;">দিনাজপুর-৬</span>
                        <div style="display: flex; gap: 10px;">
                            <span style="background: #fff3e0; color: #b85e00; padding: 5px 12px; border-radius: 50px; font-size: 13px; font-weight: 700;">
                                🌾 <?php echo $winners[6]['dhaner_win'] ?? 0; ?>
                            </span>
                            <span style="background: #e8eaf6; color: #1a237e; padding: 5px 12px; border-radius: 50px; font-size: 13px; font-weight: 700;">
                                🧔⚖️ <?php echo $winners[6]['dari_win'] ?? 0; ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 20px; text-align: center; padding: 15px; background: #1e3c4f; border-radius: 20px; color: white;">
                    <i class="fas fa-print" style="margin-right: 8px;"></i>
                    Printed by Montazar | © ২০২৬
                </div>
            </div>
        </div>
        
        <!-- ফুটার -->
        <div class="footer-mobile">
            <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                <span><i class="fas fa-sync-alt"></i> অটো রিফ্রেশ ৩০সে</span>
                <span><i class="fas fa-print"></i> Printed by Montazar</span>
            </div>
            <p style="opacity: 0.8;">সর্বশেষ আপডেট: <?php echo date('d F Y, h:i A'); ?></p>
            <p style="font-size: 12px; margin-top: 15px; opacity: 0.6;">দিনাজপুর-১ (বিরামপুর) ও দিনাজপুর-৬ (ঘোড়াঘাট-হিলি) আসনের প্রাথমিক ফলাফল</p>
        </div>
    </div>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        // Swiper ইনিশিয়ালাইজ
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1.2,
            spaceBetween: 15,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1.5,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                }
            }
        });
        
        // ট্যাব ফাংশন
        function showTab(tabName) {
            // সব ট্যাব লুকাও
            document.getElementById('results-tab').style.display = 'none';
            document.getElementById('screenshots-tab').style.display = 'none';
            document.getElementById('stats-tab').style.display = 'none';
            
            // সিলেক্টেড ট্যাব দেখাও
            if(tabName === 'results') {
                document.getElementById('results-tab').style.display = 'block';
            } else if(tabName === 'screenshots') {
                document.getElementById('screenshots-tab').style.display = 'block';
                // Swiper রিফ্রেশ
                setTimeout(() => {
                    if(swiper) swiper.update();
                }, 100);
            } else if(tabName === 'stats') {
                document.getElementById('stats-tab').style.display = 'block';
            }
            
            // একটিভ ক্লাস আপডেট
            document.querySelectorAll('.tab-item').forEach(item => {
                item.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }
        
        // টাচ অপ্টিমাইজেশন
        document.addEventListener('touchstart', function(){}, {passive: true});
        
        // প্রিভেন্ট জুম অন ডাবল ট্যাপ
        document.addEventListener('touchend', function(event) {
            if (event.target.closest('.seat-card-mobile, .tab-item, .swiper-slide')) {
                event.preventDefault();
            }
        }, {passive: false});
    </script>
</body>
</html>