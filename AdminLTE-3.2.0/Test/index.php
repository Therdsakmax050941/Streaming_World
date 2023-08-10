<!DOCTYPE html>
<html>

<head>
    <title>Auto Increment Input Value</title>
</head>

<body>
    <input type="number" id="myInput" value="">



    <script>
        const input = document.getElementById('myInput');

            input.addEventListener('change', function() {
            const currentValue = parseFloat(input.value);
            const newValue = currentValue + 1;

            // ไม่ได้กำหนดค่าใหม่ให้กับ input
            // input.value = newValue; // ตัวนี้ถูกคอมเมนท์ออก
        });
    </script>
</body>

</html>