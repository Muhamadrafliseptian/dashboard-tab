<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>
        Checkout Pembayaran
    </title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        iframe {
            border: none;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <iframe src="{{ session('payment_url') }}" frameborder="0"></iframe>

    <script type="text/javascript">
        const externalId = "{{ session('external_id') }}"
        const encryptId = "{{ session('encrypt') }}"

        const checkPaymentUrl =
            `https://3678-2400-9800-6032-ba2-143b-bf38-923f-155c.ngrok-free.app/api/organization/payment/${externalId}/check`

        function checkPaymentStatus() {
            fetch(checkPaymentUrl, {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then((res) => res.json())
                .then((response) => {
                    if (response.status_transaksi == "PAID") {
                        window.location.href = "confirm/" + encryptId
                    } else {
                        console.log("LOG");
                    }
                }).catch((error) => {
                    console.error("Error : ", error)
                })
        }

        setInterval(checkPaymentStatus, 5000);
    </script>
</body>

</html>
