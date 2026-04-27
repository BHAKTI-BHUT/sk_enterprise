<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Low Stock Alert</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px;
            line-height: 1.6;
        }
        .product-card {
            background: #fdfdfd;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            display: flex;
            align-items: center;
        }
        .product-info {
            flex-grow: 1;
        }
        .product-name {
            font-size: 20px;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 5px;
        }
        .stock-level {
            font-size: 16px;
            color: #d63031;
            font-weight: 700;
        }
        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: #2d3436;
            color: white !important;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 20px;
            transition: transform 0.2s;
        }
        .accent-bar {
            height: 4px;
            background: #ff4b2b;
            width: 100px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 10px;"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
            <h1>STOCK ALERT</h1>
        </div>
        <div class="content">
            <p>Hello Admin,</p>
            <p>This is an automated notification to inform you that one of your products has reached a critical stock level. Immediate restock is recommended to prevent service disruption.</p>
            
            <div class="accent-bar"></div>

            <div class="product-card">
                <div class="product-info">
                    <div class="product-name">{{ $product->name }}</div>
                    <p style="margin: 5px 0; color: #636e72;">Category: {{ $product->category->name ?? 'N/A' }}</p>
                    <div class="stock-level">Current Stock: {{ $product->stock_quantity }}</div>
                    <p style="font-size: 13px; color: #a4b0be; margin-top: 5px;">Alert Threshold: {{ $product->min_stock_alert }} units</p>
                </div>
            </div>

            <p style="text-align: center;">
                <a href="{{ route('product.edit', $product->id) }}" class="btn">Update Stock Now</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} SK Enterprise - Inventory Management System. All rights reserved.
        </div>
    </div>
</body>
</html>
