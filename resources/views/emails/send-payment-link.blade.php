<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="color-scheme" content="light" />
    <meta name="supported-color-schemes" content="light" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Link</title>
    <style>
        body {
            color: #233142 !important;
            font-family: 'arial';
        }

        @media (max-width: 767px) {
            .banner-container {
                height: 20rem !important;
            }

            .text-container {
                font-size: 1.2rem !important;
            }

            .logo-container img {
                margin-top: 10rem !important;
            }

            .header img {
                width: 40%;
            }

            .download-btn-container {
                font-size: 1.2rem !important;
            }
        }
    </style>
</head>

<body style="background-color: white !important; font-family: 'arial'">
    <div class="full-email-container" style="
        background-color: #bbbbbb;
        padding: 1rem;
        width: 600px;
        max-width: 90%;
        margin: 0rem auto;
        ">
        <div class="header" style="padding: 0 0 1rem">
            <img src="https://makadiheights.com/logoBig.png" width="30%" alt="" srcset=""
                style="float: left" />
            <div class="address" style="
            float: right;
            font-size: 0.7rem;
            text-align: right;
            color: #fff;
            ">
                <div class="need-help" style="margin-bottom: 0.2rem">
                    Need assistance?
                    <a target="_blank" href="https://makadiheights.com/contact-us"
                        style="color: #21436e; text-decoration: none">Contact us</a>
                </div>
                Real Estate Inquiries: 16595
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="banner-container" style="
            background-image: url('{{ $bannerUrl }}');
            height: 25rem;
            width: 100%;
            position: relative;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        ">
            <div class="content">
                <div class="overlay" style="
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                background: linear-gradient(
                    180deg,
                    rgba(196, 196, 196, 0) 0%,
                    rgba(33, 67, 111, 0.9) 100%
                );
            "></div>
                <div style="width: 100%">
                    <div class="logo-container">
                        <img src="{{ $logoUrl }}" style="
                            padding: 3rem 2rem;
                            background-color: #fff;
                            width: 100px;
                            margin-top: 14rem;
                            margin-right: 1rem;
                            display: inline-block;
                            float: right;
                            z-index: 12;
                            position: relative;
                        " />
                    </div>
                </div>
            </div>
        </div>

        <div class="email-body-container" style="
            display: block;
            background-color: #fff !important;
            width: 100%;
            padding-bottom:2.5rem;
        ">
            <div class="text-container" style="font-size: 2rem; padding: 2.5rem 2.5rem 0; font-weight: 800">
                Dear {{ $name }},
            </div>
            <div class="order-details-container" style="text-align: center; margin: 1rem">
                <div class="order-number" style="
                color: #233142;
                font-size: 1.1rem;
                text-align: left;
                padding: 1.5rem 1.5rem 0;
            ">
                    Thanks for your interest in Makadi Heights. Please review your booking details by clicking below. Kindly make sure to finalize the payment within the next {{$valid_hours}} Hours to keep the unit reserved for you. For any questions, please contact your MH sales representative.
                </div>
            </div>
            <a class="download-btn-container" href="{{ $link }}" style="
                padding: 1rem 0.5rem;
                width: 40%;
                background-color: #21436e;
                border: 1px solid #fff;
                color: #fff;
                font-size: 1.1rem;
                text-align: center;
                text-decoration: none;
                display: block;
                margin: 2.5rem;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
            ">
                View & Pay
                {{-- <img src="https://makadiheights.com/orascom-circle.svg"
                    style="display: inline;margin-left: 5px;color:#fff" width="12px" alt="" srcset=""> --}}
            </a>
            <div class="contact-us-container" style="text-align: lef; margin: 0.75rem 2rem">
                <div class="sub" style="font-size: 0.875rem; margin-bottom: 0.3rem">
                    Nile City Towers, North Tower 12th Floor, 2005 A Corniche El Nil,
                    Ramlet Boulaq
                </div>
                <div class="sub" style="font-size: 0.875rem">
                    info@makadiheights.com
                </div>
            </div>
            <div class="contact-us-container" style="margin: 0.75rem 2rem">
                <div class="header" style="font-weight: 900; margin-bottom: 0.5rem; font-size: 1.3rem">
                    Follow us
                </div>
                <div class="links">
                    <a href="https://www.facebook.com/MakadiHeights" class="link"><img src="{{ asset('icons/facebook.svg') }}" alt=""
                            style="height: 1.3rem; width: 1.3rem; margin: 0.4rem" /></a>
                    {{-- <a href="https://www.youtube.com/channel/UC3_iScZn7ySHLUAHiM3zKdQ" class="link"><img src="{{ asset('icons/twitter.svg') }}" alt=""
                            style="height: 1.3rem; width: 1.3rem; margin: 0.4rem" /></a> --}}
                    <a href="https://www.instagram.com/makadiheights" class="link"><img src="{{ asset('icons/instagram.svg') }}" alt=""
                            style="height: 1.3rem; width: 1.3rem; margin: 0.4rem" /></a>
                </div>
            </div>
        </div>
        <div class="footer" style="
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            background-color: white;
            padding: 1rem 1rem;
            height: fit-content;
            border-top: 0.4px solid rgba(23, 31, 42, 0.4);
            margin-top: 1rem;
            font-size: 0.8rem;
        ">
            <div style="float: left">&copy; 2022 Makadi Heights</div>
            {{-- <div style="margin-left: auto">Terms and conditions</div> --}}
        </div>
    </div>
</body>

</html>
