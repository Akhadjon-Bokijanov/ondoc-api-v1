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

<div style="border-bottom: 1px solid black; margin-bottom: 10px; margin-top: -17px;font-size: 11px ">ID: {{ strtolower($data->facturaId) }}</div>


<div>
<table>
    <tr style="align-items: end">
        <td width="200px"></td>
        <td width="30%" style="text-align: center">СЧЕТ-ФАКТУРА
            <br> № {{$data->facturaNo}}
            <br><span style="font-size: 10px">от {{ $data->facturaDate }}</span>
            <br>к договорам № {{ $data->contractNo }}
            <br><span style="font-size: 10px">от {{ $data->contractDate }}</span>
        </td>
        <td width="30%">
            {{ \SimpleSoftwareIO\QrCode\Facades\QrCode::backgroundColor(255,255,255)->size(150)->generate('QR Code Generator for Laravel!') }}
        </td>
    </tr>
</table>
</div>
<div>
    <table>
    <tr>
        <tr>
            <td>
                Поставщик:
            </td>
            <td>
                {{ $data->sellerName }}
            </td>
        </tr>
        <td>
            Адрес:
        </td>
        <td>
            Идентификационный номер
            поставщика (ИНН):
        </td>
        <td>
            Регистрационный код
            плательщика НДС
        </td>
        <td>
            Расчётный счёт
        </td>
        <td>
            МФО банка:
        </td>
    </tr>
</table>
</div>
<table width="100%" style="font-family: serif;" cellpadding="10"><tr>
        <td width="45%" style="border: 0.1mm solid #888888; "><span style="font-size: 7pt; color: #555555; font-family: sans;">SOLD TO:</span><br /><br />345 Anotherstreet<br />Little Village<br />Their City<br />CB22 6SO</td>
        <td width="10%">&nbsp;</td>
        <td width="45%" style="border: 0.1mm solid #888888;"><span style="font-size: 7pt; color: #555555; font-family: sans;">SHIP TO:</span><br /><br />345 Anotherstreet<br />Little Village<br />Their City<br />CB22 6SO</td>
    </tr></table>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
    <tr>
        <td rowspan="2" width="3%">№</td>
        <td rowspan="2" width="25%">Наименование товаров (работ, услуг)</td>
        <td rowspan="2" width="20%" style="overflow-x: hidden">Идентификационный код</td>
        <td rowspan="2" width="10%">Единица измерения</td>
        <td rowspan="2" width="10%">Количество</td>
        <td rowspan="2" width="10%">Стоимость поставки</td>
        <td colspan="2">НДС</td>
        <td rowspan="2" width="15%">Стоимость поставки с ставка сумма учётом НДС</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td rowspan="1">ставка</td>
        <td rowspan="1">сумма</td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    @foreach($data->facturaProducts as $product){
        echo <tr>
        <td align="center">{{$product->ordNo}}</td>
        <td align="center">{{ $product->name }}</td>
        <td>{{ $product->catalogCode }} - {{ $product->catalogName }}</td>
        <td class="cost">{{ $product->measureId }}</td>
        <td class="cost">{{ $product->count }}</td>
        <td>{{ $product->baseSumma }}</td>
        <td>{{ $product->vatRate }}</td>
        <td>{{ $product->baseSumma * $product->varRate/100 }}</td>
        <td>{{$product->deliverySumWithVat}}</td>
    </tr>
    }
    @endforeach

    <!-- END ITEMS HERE -->
    <tr>
        <td class="blanktotal" colspan="3" rowspan="6"></td>
        <td class="totals">Subtotal:</td>
        <td class="totals cost">&pound;1825.60</td>
    </tr>
    <tr>
        <td class="totals">Tax:</td>
        <td class="totals cost">&pound;18.25</td>
    </tr>
    <tr>
        <td class="totals">Shipping:</td>
        <td class="totals cost">&pound;42.56</td>
    </tr>
    <tr>
        <td class="totals"><b>TOTAL:</b></td>
        <td class="totals cost"><b>&pound;1882.56</b></td>
    </tr>
    <tr>
        <td class="totals">Deposit:</td>
        <td class="totals cost">&pound;100.00</td>
    </tr>
    <tr>
        <td class="totals"><b>Balance due:</b></td>
        <td class="totals cost"><b>&pound;1782.56</b></td>
    </tr>
    </tbody>
</table>
<div style="text-align: center; font-style: italic;">Payment terms: payment due in 30 days</div>

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
