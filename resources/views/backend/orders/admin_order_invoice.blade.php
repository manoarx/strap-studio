<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
    <title>Strap Studios Invoice</title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  </head>
  <body style="font-size: 10pt;font-family: Arial, sans-serif;" style="font-family: arial;">
    <table style="" cellpadding="0" cellspacing="0" border="0">
      
        
      <tbody>
          <tr>
          <td ng-if="showField('logo')" width="160" style="font-size: 10pt;vertical-align: top;padding-top: 15px;padding-bottom: 5px;" valign="top">
            <a href="{logoURL}" target="_blank">
              <img border="0" alt="Logo" width="140" style="width: 140px;height:auto;border:0;" src="https://www.strapstudios.com/wp-content/uploads/2019/09/cropped-logo.png">
            </a>
          </td>
          <td style="width: 200px;"></td>
          <td valign="top" style="vertical-align: middle;line-height:11px;text-align: right;padding-right: 20px;padding-top: 5px;padding-bottom: 5px;width: 300px;">
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;text-align: left;">
              <tbody>
                <tr>
                  <td style="line-height: 18px;text-decoration: none;vertical-align: middle;font-size: 12pt;color: #000000;padding-bottom: 3px;font-weight: 600;">Strap Studios </td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">Office # 1704 – ADCP Business Tower C,</td>
                </tr>
                <tr>
                  <td style="line-height: 20px;text-decoration: none;vertical-align: middle;font-size: 11pt;color: #000000;padding-bottom: 3px;">Electra Street, Abu Dhabi – 42747</td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">Phone: +971 2 6772216</td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;">Email: info@strapstudios.com</td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td ng-if="showField('logo')" width="160" style="font-size: 10pt;font-family: Arial, sans-serif;vertical-align: top;padding-top: 30px;padding-bottom: 20px;" valign="top">
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;text-align: left;">
              <tbody>
                <tr>
                  <td style="line-height: 26px;text-decoration: none;vertical-align: middle;font-size: 20pt;color: #000000;padding-bottom: 30px;font-weight: 600;">INVOICE </td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">{{ $order->name }} </td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;">{{ $order->email }} </td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;">{{ $order->phone }} </td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;">{{ $order->adress }} </td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;">{{ $order->post_code }} </td>
                </tr>
              </tbody>
            </table>
          </td>
          <td style="padding-top: 30px;padding-bottom: 20px;width: 200px;"></td>
          <td valign="top" style="vertical-align: top;line-height:11px;text-align: left;padding-top: 30px;padding-bottom: 20px;width: 300px;">
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;text-align: left;padding-top: 57px;">
              <tbody>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">Invoice Number: </td>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">#{{ $order->invoice_no }} </td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">Order Date: </td>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">{{ $order->order_date }} </td>
                </tr>
                <tr>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">Payment Method: </td>
                  <td style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 11pt;color: #000000;padding-bottom: 3px;">{{ $order->payment_method }} </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td style="vertical-align: bottom;height: 10px;" valign="top" colspan="3">
            <table style="text-decoration: none;font-family: Arial, sans-serif;font-size: 9pt;color: #888888;width: 100%;" cellpadding="0" cellspacing="0">
              <thead style="background: #000;">
                <tr>
                  <td valign="middle" style="padding-top: 10px;padding-bottom: 10px;color: #fff;font-size: 11pt;padding-left: 5px;line-height: 20px;padding-right: 20px;">
                    <span>Product</span>
                  </td>
                  <td valign="middle" style="padding-top: 10px;padding-bottom: 10px;color: #fff;font-size: 11pt;padding-left: 20px;line-height: 20px;padding-right: 20px;">
                    <span>Quantity</span>
                  </td>
                  <td valign="middle" style="padding-top: 10px;padding-bottom: 10px;color: #fff;font-size: 11pt;padding-left: 20px;line-height: 20px;text-align: left;padding-right: 20px;">
                    <span>Price</span>
                  </td>
                </tr>
              </thead>
              <tbody>
                @foreach($orderItem as $item)
                @php
                if($item->product_type == 'workshop') {
                  $itemtype = $item->workshop;
                } elseif($item->product_type == 'service') {
                  $itemtype = $item->service;
                } elseif($item->product_type == 'studiorental') {
                  $itemtype = $item->studiorental;
                } else {
                  $itemtype = $item->product;
                } 
                @endphp
                <tr>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 5px;
    line-height: 20px;
    padding-right: 20px;
    border-bottom: 1px solid #BCBCBC;
">
                    <label style="
    width: 100%;
    display: block;
">{{ $itemtype->title }}</label>
                    <!-- <span style="font-size: 11px;">SKU: STRAP-SP-LLM-6A</span> -->
                  </td>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    border-bottom: 1px solid #BCBCBC;
">
                    <span>{{ $item->qty }}</span>
                  </td>
                  <td valign="middle" style="
    text-align: left;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    border-bottom: 1px solid #BCBCBC;
">
                    <span>AED{{ $item->price }}</span>
                  </td>
                </tr>
                @endforeach
                <tr>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
"></td>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    font-weight: 600;
    border-bottom: 1px solid #BCBCBC;
"></td>
                  <td valign="middle" style="
    text-align: left;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    font-weight: 600;
    border-bottom: 1px solid #BCBCBC;
"></td>
                </tr>
                <!-- <tr>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
"></td>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    font-weight: 600;
    border-bottom: 1px solid #BCBCBC;
">
                    <span>Subtotal</span>
                  </td>
                  <td valign="middle" style="
    text-align: left;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    border-bottom: 1px solid #BCBCBC;
">
                    <span>AED{{ $order->amount }}</span>
                  </td>
                </tr> -->
                @if($item->product_type == 'school')
                <tr>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
"></td>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    font-weight: 600;
    border-bottom: 1px solid #BCBCBC;
">
                    <span>Shipping</span>
                  </td>
                  <td valign="middle" style="
    text-align: left;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    border-bottom: 1px solid #BCBCBC;
    width: 150px;
">
                    <span>Collect from School Collection date updated by school</span>
                  </td>
                </tr>
                @endif
                <tr>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
"></td>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    font-weight: 600;
    border-bottom: 2px solid #000;
">
                    <span>VAT</span>
                  </td>
                  <td valign="middle" style="
    text-align: left;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    border-bottom: 2px solid #000;
">
@php
$vatPercentage = 5;
$vatAmount = $order->amount * ($vatPercentage / 100);
@endphp
                    <span>AED {{ $vatAmount }}</span>
                  </td>
                </tr>
                <tr>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
"></td>
                  <td valign="middle" style="
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    font-weight: 600;
    border-bottom: 2px solid #000;
">
                    <span>Total</span>
                  </td>
                  <td valign="middle" style="
    text-align: left;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #000;
    font-size: 11pt;
    padding-left: 20px;
    line-height: 20px;
    padding-right: 20px;
    font-weight: 600;
    border-bottom: 2px solid #000;
">
                    <span>AED{{ $order->amount }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="3" style="padding-top: 50px;text-align: justify;padding-bottom: 30px;"></td>
        </tr>
        <tr>
          <td colspan="3" style="padding-top: 20px;text-align: justify;padding-bottom: 30px;border-top: 1px solid #222;">
            <span style="line-height: 20px;vertical-align: middle;text-decoration: none;font-size: 10pt;color: #000;width: 100%;display: block;text-align: center;">Thank you for your business! </span>
          </td>
        </tr>
      </tbody>
    </table>
  
</body></html>