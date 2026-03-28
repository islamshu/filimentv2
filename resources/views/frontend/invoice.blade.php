<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> طباعة الفاتورة </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function pafD() {
            let filePDF = document.getElementById('main');
            html2pdf().from(filePDF).save();
        }
    </script>
    <style>
          @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap');

* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Tajawal', sans-serif;
    font-size: 12px;
    font-weight: 500;
}

:root {
    --main-color: #643543
}

body {
    padding: 20px;
    --main-color: #000
}

.page_invoce {
    /* width: 550px; */
    margin: 0 auto;
    height: auto;
    background-color: #fff;
    padding: 10px 20px;
}

.Heading_info img {
    width: 50px;
}

.flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.center {
    display: flex;
    align-items: center;
    gap: 10px;
}

.NameSite,
.Date {
    color: var(--main-color);
    font-weight: bold;
    font-size: 15px;
}

.info_customer {
    margin-top: 20px;
    border: 1px solid #989898;
    padding: 15px 10px;
    border-radius: 10px;
}

.info_customer span,
.text_info_table span {

    color: #777;
    font-weight: bold;
}

.info_customer div,
.text_info_table div {
    color: var(--main-color);
    font-weight: bold;

}

.table table {
    margin-top: 15px;
    border-collapse: collapse;
    width: 100%;
}

.table thead tr {
    background-color: var(--main-color);
    color: #fff;
}

.table thead tr th {
    padding: 7px;
}

.table thead tr th {
    background-color: #1fa2d8;
    color: #fff;
    height: 25px;
    padding: 0 5px;
    line-height: 3;
}

tbody tr {
    /*background-color: #e3e3e3;*/
    color: var(--main-color);
    font-size: 17px;
    border-top: 1px solid #fff;
}

tbody tr td {
    padding: 7px;
    text-align: center;
}

tbody tr:nth-child(even) {
    /*background-color: #f2f2f2;*/
}

.table td,
.table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

footer {
    padding: 10px;
    background-color: var(--main-color) !important;
    margin-top: 10px;
}

footer div {
    color: #fff;
}

.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(-1 * var(--bs-gutter-y));
    margin-left: calc(-0.5 * var(--bs-gutter-x));
    margin-right: calc(-0.5 * var(--bs-gutter-x));
}

.col-6 {
    flex: 0 0 auto;
    width: 50%;
}
    </style>
</head>

<body>
    <button onclick="pafD()" style="width: 100px; height: 40px; background-color: #00a8ff; border: 1px solid; color: #ffffff; font-size: 15px;">تحميل</button>
    <div id="main" style="padding: 5px; max-width: 80%; margin: auto;">
        <div class="page_invoce" style="border: 1px solid #000; border-radius: 10px; padding: 30px;">
            <div class="Heading_info flex">
                <div class="Logo center"><span class="NameSite">{{ get_general_value('website_name') }}</span></div>
                <div class="Logo center"><img style="width: 100px;"
                        src="{{ asset('storage/' . get_general_value('web_logo')) }}"></div>
                <div class="Logo center"><span class="NameSite">{{ $order->website_name_en }}</span></div>
            </div>
            <div class="info_customer flex" style="align-items: flex-start;">
                <div class="info_cus">
                    <div style="color: #f00;"><span>رقم الفاتورة : </span> {{ $order->code }}# </div>
                    <div><span>اسم العميل : </span> {{ $order->name }} </div>
                    <div><span>رقم الهاتف : </span> {{ $order->phone }} </div>
                </div>
                <div class="info_cus">
                    <div style="text-align: right;"><span>التاريخ : </span> {{ $currentDate }}</div>
                    <div style="text-align: right;"><span>العنوان : </span> {{ $order->location }} </div>
                </div>
            </div>
            <hr style="margin-top: 10px;">
            <div class="table" style="margin-top: 10px;">
                <h4 style="text-align: center;">تفاصيل الطلب</h4>
                <div class="table_Res">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ $detail->price }} {{ get_currancy() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="table" style="margin-top: 10px;">
                <div class="text_info_table flex" style="align-items: flex-start;">
                    <div>
                        <div style="text-align: right;"><span>مدة الأقساط : </span> {{ $order->CashOrBatch }} </div>
                        <div style="text-align: right; color: #f00"><span>المبلغ الكلي : </span> {{ $totalPrice }}
                            {{ get_currancy() }}</div>
                    </div>
                    <div>
                        <div style="text-align: right;"><span>الدفعة الأولى : </span> {{ $order->first_batch }}
                            {{ get_currancy() }}</div>
                        <div style="text-align: right;"><span>الختم : </span></div>
                    </div>
                </div>
            </div>
            <div>
            </div>
            <div class="table" style="margin-top: 10px;">
                <div>
                    <div style="text-align: left;"><img
                            style="width: 60px; margin: -24px 35px; transform: rotate(-20deg);"
                            src="{{ asset('storage/' . get_general_value('segnature')) }}"></div>
                </div>
            </div>
            <div>
                
                <table class="table" style="width:100%;margin-top:10px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>المبلغ</th>
                                            <th>تاريخ الاستحقاق</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($order->payment_getway == 'tappy' || $order->payment_getway == 'tmara' )
                                     
                                        @for ($i = 0; $i < 4; $i++)
                                        @php
                                        $date = \Carbon\Carbon::parse($order->created_at)->addMonths($i);
                                      @endphp
                                        <tr>
                                            <th>{{ $i + 1 }}</th>
                                            <th>{{ $order->first_batch .' '.get_currancy() }}</th>
                                            <th>{{ $date->format('Y/m/d') }}</th> <!-- Format the date to your needs -->
                                        </tr>
                                        @endfor
                                        @elseif($order->payment_getway == 'installment')
                                        <tr>
                                            <th>1</th>
                                            <th>{{ $order->first_batch .' '.get_currancy() }}</th>
                                            <th>{{ $order->created_at->format('Y/m/d') }}</th> <!-- Format the date to your needs -->
                                        </tr>
                                        @for ($i = 0; $i < $order->CashOrBatch; $i++)
                                        @php
                                              $date = \Carbon\Carbon::parse($order->created_at)->addMonths($i+1);
                                              $each = ($order->payment -  $order->first_batch) / $order->CashOrBatch;
                                        @endphp
                                        <tr>
                                            <th>{{ $i + 2 }}</th>
                                            <th>{{ number_format($each, 2) . ' ' . get_currancy() }}
                                            </th>
                                            <th>{{ $date->format('Y/m/d') }}</th> <!-- Format the date to your needs -->
                                        </tr>
                                        @endfor
                                        @elseif($order->payment_getway == 'all')
                                        <tr>
                                            <th>1</th>
                                            <th>{{ number_format($order->first_batch, 2) . ' ' . get_currancy() }}
                                            </th>
                                            <th>{{ $order->created_at->format('Y/m/d') }}</th> <!-- Format the date to your needs -->
                                        </tr>
                                        @endif
                                                                
                                      
                                     
                                                                
                                    </tbody>
                                </table>
                                              
                            </div>
            <footer class="flex">
                <div>
                    <span>{{ get_general_value('whatsapp') }}</span>
                </div>
                <div>
                    <span>{{ get_general_value('email') }}</span>
                </div>
            </footer>
        </div>
    </div>
    <script>
        let  tbody   = document.querySelector(".Table_Tackset table tbody");
        let  ini     = document.getElementById("by").value;
        let firstpay = document.getElementById("firstpay").value;
        let toatl    = document.getElementById("toatl").value; 
        let cur   = document.getElementById("cur").value; 

        let Resultpay = parseFloat(toatl) - parseFloat(firstpay);
        let valFirstpay = Resultpay / ini;
        let numpay = 1;

        var Toatalpay = parseFloat(firstpay);

        var d = new Date();
        for(let x = 0 ; x <ini ; x++ )
        { 
            Toatalpay+=valFirstpay;
            d.setMonth(d.getMonth() + 1);
            var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
            let temp = `<tr>  <td>الدفعة ${x + 1}</td> <td>${strDate}</td> <td>${valFirstpay.toFixed(2)}</td> <td class = "Toatl">${Toatalpay.toFixed(2)}</td> </tr>`;
            tbody.innerHTML += temp;
            
        }
    </script>
</body>

</html>
