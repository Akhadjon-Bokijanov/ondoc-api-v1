<?php
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

$qrCode = new QrCode('{"FileType": "1", "Tin":"'.$data->sellerTin.'", "Id":"'. $data->facturaId .'"}');

?>



<html>
<head>
    <style>
        body {font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
        }
        p {	margin: 0pt; }
        table.items {
            border: 0.1mm solid #000000;
        }
        td { vertical-align: top; }
        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }
        table thead td { background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
            font-variant: small-caps;
        }
        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }
        .items td.totals {
            text-align: right;
            border: 0.1mm solid #000000;
        }
        .items td.cost {
            text-align: "." center;
        }

    </style>
</head>
<body>

<div style="border-bottom: 1px solid black; height: 18px;margin-bottom: 15px; margin-top: -17px;font-size: 11px; position: fixed; ">ID: {{ strtolower($data->facturaId) }}</div>

<div>
<table width="100%">
    <tr>
        <td width="30%"></td>
        <td width="30%" style="padding: 40px 10px;" align="center">СЧЕТ-ФАКТУРА
            <br> № {{$data->facturaNo}}
            <br><span style="font-size: 10px">от {{ $data->facturaDate }}</span>
            <br>к договорам № {{ $data->contractNo }}
            <br><span style="font-size: 10px">от {{ $data->contractDate }}</span>
        </td>
        <td width="30%" align="right">
            <img style="width: 110px; height: 110px" src="{{ $qrCode->writeDataUri() }}" alt="">
        </td>
    </tr>
</table>
</div>

<table width="100%">
    <tr>
        <td style="width: 45%">
            <table width="90%" style="font-size: 11px;" cellpadding="3">
                <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">Поставщик:</td><td>{{ $data->sellerName }}</td>
                    <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">Адрес:</td><td>{{ $data->sellerAddress }}</td>
                </tr>
                <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">ИНН:</td><td>{{ $data->sellerTin }}</td>
                </tr>
                    <tr>
                        <td width="150px" style="font-weight: bold; text-align: right">Расчётный счёт:</td><td>{{ $data->sellerAccount }}</td>
                    </tr>
                <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">МФО банка:</td><td>{{ $data->sellerBankId }} bankId</td>
                </tr>

            </table>
        </td>
        <td style="width: 10%"></td>
        <td style="width: 45%">
            <table width="90%" style="font-size: 11px" cellpadding="3">
                <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">Поставщик:</td><td>{{ $data->buyerName }}</td>
                <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">Адрес:</td><td>{{ $data->buyerAddress }}</td>
                </tr>
                <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">ИНН:</td><td>{{ $data->buyerTin }}</td>
                </tr>
                <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">Расчётный счёт:</td><td>{{ $data->buyerAccount }}</td>
                </tr>
                <tr>
                    <td width="150px" style="font-weight: bold; text-align: right">МФО банка:</td><td>{{ $data->buyerBankId }} bankId</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br />


<table class="items" width="100%" style="font-size: 7pt; border-collapse: collapse; " cellpadding="4">
    <thead>
    <tr>
        <td rowspan="2" width="3%">№</td>
        <td rowspan="2" width="25%">Наименование товаров (работ, услуг)</td>
        <td rowspan="2" width="20%" style="overflow-x: hidden">Идентификационный код</td>
        <td rowspan="2" width="5%">Единица измерения</td>
        <td rowspan="2" width="10%">Количество</td>
        <td rowspan="2" width="10%">Стоимость поставки</td>
        <td colspan="2" rowspan="1">НДС</td>
        <td rowspan="2" width="15%">Стоимость поставки с ставка сумма учётом НДС</td>
    </tr>
    <tr>
        <td rowspan="1">ставка</td>
        <td rowspan="1" style="border-right: 1px solid black">сумма</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    @foreach($data->facturaProducts as $product){
        echo <tr>
        <td align="center">{{$product->ordNo}}</td>
        <td align="center">{{ $product->name }}</td>
        <td>{{ $product->catalogCode }} - {{ $product->catalogName }}</td>
        <td class="cost">{{ $product->measure->name }}</td>
        <td class="cost">{{ $product->count }}</td>
        <td>{{ $product->baseSumma }}</td>
        <td>{{ $product->vatRate }}</td>
        <td>{{ $product->baseSumma * $product->vatRate/100 }}</td>
        <td>{{$product->deliverySumWithVat}}</td>
    </tr>
    }
    @endforeach

    <!-- END ITEMS HERE -->
    <tr>
        <td class="totals" colspan="4">Итого:</td>
        <td class="totals cost">&pound;1825.60</td>
        <td class="totals"></td>
        <td class="totals"></td>
        <td class="totals"></td>
        <td class="totals"></td>
    </tr>
    </tbody>
</table>

<table width="100%" style="margin-top: 20px; font-size: 11px" >
    <tr>
        <td width="15%" style="font-weight: bold">Руководитель:</td>
        <td width="20%">{{ $data->sellerDirector }}</td>
        <td width="15%"></td>
        <td width="15%" style="font-weight: bold">Руководитель:</td>
        <td width="20%">{{ $data->buyerDirector }}</td>
    </tr>
    <tr>
        <td width="15%" style="font-weight: bold">Главный бухгалтер:</td>
        <td width="20%">{{ $data->sellerAccountant }}</td>
        <td width="15%"></td>
        <td width="15%" style="font-weight: bold">Главный бухгалтер:</td>
        <td width="20%">{{ $data->buyerAccountant }}</td>
    </tr>
    <tr>
        <td width="15%" style="font-weight: bold">Товар отпустил:</td>
        <td width="20%">{{ $data->agentFio }}</td>
        <td width="15%"></td>
    </tr>
</table>

<script>
    var a = document.querySelector('svg');

    a.setAttribute('fill', "#000000");

</script>

<script type="text/php">
	if ( isset($pdf) ) {
	    $pdf->page_script('
	        if ($PAGE_COUNT > 1) {
	            $font = $fontMetrics->get_font("DejaVu Sans, sans-serif", "normal");
	            $size = 8;
	            $pageText = "Страница " . $PAGE_NUM . " из " . $PAGE_COUNT;
	            $y = 22;
	            $x = 740;
	            $pdf->text($x, $y, $pageText, $font, $size);
	        }
	    ');
	}
</script>

</body>
</html>
