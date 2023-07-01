<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="color-scheme" content="light" />
    <meta name="supported-color-schemes" content="light" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Makadi Heights</title>
    <style>
        body {
            color: #233142 !important;
            font-family: "arial";
        }

        .modal-summary-container .title,
        .modal-summary-container .data {
            font-size: 1rem;
            margin-bottom: 1rem;
            color: #999999;
        }

        .unit-desc {
            font-size: .8rem;
        }

        @media (max-width: 767px) {
            * {
                box-sizing: border-box;
            }

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
                width: calc(100%) !important;
            }

            .unit-img {
                margin-bottom: 1rem !important;
            }

            .unit-desc {
                padding: 0 .7rem !important;
                text-align: center !important;
            }

            .unit-desc p {
                width: 50% !important;
                font-size: .6rem;
                line-height: .9;
            }

            .unit-desc p.zone-desc {
                width: 100% !important;
                font-size: .8rem;
            }

            .unit-desc p span {
                display: block !important;
                font-size: .6rem;
            }

            .unit-img,
            .unit-desc {
                width: 100% !important;
                float: none !important;
            }

            .modal-summary-container .title,
            .modal-summary-container .data {
                font-size: 0.7rem;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="full-email-container"
        style="
        background-color: #bbbbbb;
        padding: 1rem;
        width: 600px;
        max-width: 90%;
        margin: 0rem auto;
      ">
        <div class="header" style="padding: 0 0 1rem">
            <img src="https://makadiheights.com/logoBig.png" width="30%" alt="" srcset=""
                style="float: left" />
            <div class="address"
                style="
            float: right;
            font-size: 0.7rem;
            text-align: right;
            color: #fff;
          ">
                <div class="need-help" style="margin-bottom: 0.2rem">
                    For assistance?
                    <a target="_blank" href="https://makadiheights.com/contact-us"
                        style="color: #21436e; text-decoration: none">Contact us</a>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="banner-container"
            style="
          background-image: url('{{ $bannerUrl }}');
          width: 100%;
          position: relative;
          height: 25rem;
          background-size: cover;
          background-position: center center;
          background-repeat: no-repeat;
        ">
            <div class="content">
                <div class="overlay"
                    style="
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
            ">
                </div>
            </div>
            <div style="width: 100%">
                <div class="logo-container">
                    <img src="{{ $logourl }}"
                        style="
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
        <div class="email-body-container"
            style="
          display: block;
          padding: 0 2rem;
          background-color: #fff !important;
        ">
            <div class="text-container"
                style="
            font-size: 1.2rem;
            padding: 2rem 0;
            font-weight: 800;
            border-bottom: 1px solid rgba(0, 56, 255, 0.2);
          ">
                ORDER NUMBER: {{ $id }}
                <br>
                <br>
                AMOUN PAID: {{ $currency }} {{ number_format($downPayment,0) }}
            </div>
            <div class="summary"
                style="
            font-size: 1rem;
            border-bottom: 1px solid rgba(0, 56, 255, 0.2);
            padding: 1rem 0;
            text-align: center;
            font-weight: 800;
          ">
                <div class="order-summary"
                    style="
              color: #999999;
              text-align: center;
              margin-bottom: 1rem;
              font-weight: 300;
            ">
                    Digital Receipt
                </div>
                Your order {{ $unitName }} at {{ $zoneName }} : Makadi Heights
            </div>
            <div class="order-summary-container" style="padding: 1rem 0">
                <div class="modal-summary-container">
                    <div class="title" style="float: left">Total unit value</div>
                    <div class="data" style="float: right">EGP {{ number_format($totalUnitPrice, 0) }}
                    </div>
                    <div style="clear: both"></div>
                    <div class="title" style="float: left">Total Amount Paid</div>
                    <div class="data" style="float: right">
                        {{ $currency }} {{ number_format($totalPaid, 0) }}
                    </div>
                    <div style="clear: both"></div>
                    <div class="title" style="float: left">Payment amount</div>
                    <div class="data" style="float: right">{{ $currency }} {{ number_format($downPayment, 0) }}
                    </div>
                    <div style="clear: both"></div>
                    {{-- <div class="title" style="float: left">
                        Due amount after payment(s)
                    </div>
                    <div class="data" style="float: right">EGP {{ number_format($dueAmount, 2) }}
                    </div>
                    <div style="clear: both"></div> --}}
                    {{-- <div class="title" style="float: left">Service tax 5%</div>
                    <div class="data" style="float: right">{{$currency}} {{ $tax }}</div> --}}
                    <hr>
                    <div class="title" style="float: left;margin-top:1rem;font-weight:800;color:#233142">
                        Due amount after payment(s) <br />
                    </div>
                    <div class="data" style="float: right;margin-top:1.2rem;font-weight:800;color:#233142">
                        EGP {{ number_format($dueAmount, 0) }}
                    </div>
                    <div style="clear: both"></div>
                    <hr>
                </div>
                {{-- <div class="download-btn-container" style="
              padding: 1rem 0.5rem;
              width: 50%;
              background-color: #21436e;
              border: 1px solid #fff;
              color: #fff;
              font-size: 1.2rem;
              text-align: center;
              text-decoration: none;
              display: block;
              margin: 2rem 0;
              text-align: center;
            ">
                    <img src="cid:download" alt="" />
                    Download Receipt
                </div> --}}
                <div class="contact-us-container" style="text-align: lef; margin: 0.75rem 0">
                    <div class="sub" style="font-size: 0.8rem; margin-bottom: 0.3rem">
                        Nile City Towers, North Tower 12th Floor, 2005 A Corniche El Nil,
                        Ramlet Boulaq
                    </div>
                    <div class="sub" style="font-size: 0.8rem">
                        info@makadiheights.com
                    </div>
                </div>
                <div class="contact-us-container" style="margin: 0.75rem 0">
                    <div class="header" style="font-weight: 900; margin-bottom: 0.5rem; font-size: 1.2rem">
                        Follow us
                    </div>
                    <div class="links">
                        <a href="https://www.facebook.com/MakadiHeights" class="link"><img
                                src="{{ asset('icons/facebook.svg') }}" alt=""
                                style="height: 1.3rem; width: 1.3rem; margin: 0.4rem" /></a>
                        {{-- <a href="" class="link"><img src="{{ asset('icons/twitter.svg') }}" alt=""
                                style="height: 1.3rem; width: 1.3rem; margin: 0.4rem" /></a> --}}
                        <a href="https://www.instagram.com/makadiheights" class="link"><img
                                src="{{ asset('icons/instagram.svg') }}" alt=""
                                style="
                    height: 1.3rem;
                    width: 1.3rem;
                    margin: 0.4rem;
                  " /></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="explore" style="
          background-color: white;
          padding: 1rem;
          font-size: .9rem;
          margin-top: 1rem;
        ">
            <h3 style="
            color: #233142;
            font-size: 1rem;
            margin: 0;
            margin-bottom: 1rem;
          ">
                Explore your new home
            </h3>
            <div class="unit-img" style="width: 49%; margin: 0; float: left">
                <img width="100%" src="{{ $bannerUrl }}" alt="" srcset="" style="max-height: 200px;" />
            </div>
            <div class="unit-desc" style="width: 49%; padding-left: 1%; float: right">
                <p style="
              width: 40%;
              padding-right: 1rem;
              float: left;
              border-right: 1px dotted #ddd;
              margin: 0;
            ">
                    <span style="text-transform: uppercase; color: #999999">Property Price</span>
                    <br>
                    L.E {{ $totalUnitPrice }}
                </p>
                <p style="
              width: 45%;
              padding-left: 1rem;
              float: left;
              margin: 0;
            ">
                    <span style="text-transform: uppercase; color: #999999"> Property Size</span>
                    <br>
                    {{ $propertySize }} m2
                </p>
                <div style="clear:both"></div>
                <p style="
              width: 40%;
              padding-right: 1rem;
              float: left;
              border-right: 1px dotted #ddd;
              margin: 0;
              margin-top: 1rem;
            ">
                    <span style="text-transform: uppercase; color: #999999">Bathrooms</span>
                    <br>
                    {{ $bathrooms }}
                </p>
                <p style="
              width: 45%;
              padding-left: 1rem;
              float: left;
              margin: 0;
              margin-top: 1rem;
            ">
                    <span style="text-transform: uppercase; color: #999999"> BEDROOM</span>
                    <br>
                    {{ $beds }}
                </p>
                <div style="clear:both"></div>
                <p style="
              width: 40%;
              padding-right: 1rem;
              float: left;
              border-right: 1px dotted #ddd;
              margin: 0;
              margin-top: 1rem;
            ">
                    <span style="text-transform: uppercase; color: #999999">UNCOVERED TERACES</span>
                    <br>
                    {{ $terraces }}
                </p>
                <p style="
              width: 45%;
              padding-left: 1rem;
              float: left;
              margin: 0;
              margin-top: 1rem;
            ">
                    <span style="text-transform: uppercase; color: #999999"> Floor</span>
                    <br>
                    {{ $bua }}
                </p>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
        </div> --}}

        <div class="explore"
            style="
          background-color: white;
          padding: 1rem;
          font-size: 0.9rem;
          margin-top: 1rem;
        ">
            <h3
                style="
            color: #233142;
            font-size: 1rem;
            margin: 0;
            margin-bottom: 1rem;
          ">
                Explore your neighbourhood: {{ $zoneName }}
            </h3>
            <div class="unit-img" style="width: 49%; margin: 0; float: left">
                <img width="100%"
                    src="https://res.cloudinary.com/doh4vcgwz/image/upload/v1644246698/Topio_1_2fd2098ae1.jpg"
                    alt="" srcset="" height="160px" />
            </div>
            <div class="unit-desc" style="width: 49%; padding-left: 1%; float: right">
                <h2 style="margin-top: 0;">
                    {{ $zoneName }}
                </h2>
                <p class="zone-desc">
                    Apartments, duplexes and floating chalets are designed with Boho-inspired architecture that features
                    serenity on every floor
                </p>
                <a class="download-btn-container" href="https://makadiheights.com/home-at-makadi/{{ $zoneSlug }}"
                    style="
            padding: .8rem;
            width: 50%;
            background-color: #21436e;
            border: 1px solid #fff;
            color: #fff;
            font-size: 1.1rem;
            text-align: center;
            text-decoration: none;
            display: block;
            margin: 1rem 0;
            text-align: center;
          ">
                    Explore
                    {{-- <img src="https://makadiheights.com/orascom-circle.svg"
                        style="display: inline;margin-left: 5px;color: #21436e;" width="17px" height="15px" alt=""
                        srcset=""> --}}
                </a>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="footer"
            style="
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
            <div style="float: left">&copy; {{ date('Y') }} Makadi Heights</div>
            {{-- <div style="margin-left: auto">Terms and conditions</div> --}}
        </div>
    </div>
</body>

</html>
