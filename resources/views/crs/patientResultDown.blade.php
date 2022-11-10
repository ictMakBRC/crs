
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>
<style>
  body{margin:0;font-family:Nunito,sans-serif;font-size:.8rem;font-weight:400;line-height:1.2;color:#6c757d;background-color:#ffffff;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent}
  hr{margin:1rem 0;color:inherit;background-color:currentColor;border:0;opacity:.25}
  hr:not([size]){height:1px}
      .text_centered {
        position: absolute;
        top: 58%;
        left: 6%;
        /* transform: translate(-50%, -50%); */
        color: red
        }
        table {
  border-collapse: collapse;
}
.btop{
 border:none;border-top:1px solid #DDDDDD 1.0pt;mso-border-top-alt:
  solid #DDDDDD .75pt;mso-border-top-alt:
  solid #DDDDDD .75pt;mso-border-bottom-alt:
  solid #DDDDDD .75pt;
  padding-top: 5px;
  padding-bottom: 5px;
  border-block-start-style: outset;
}
</style>
</head>

<body style="line-height:1.2">
    @if(count($results)>0)
    @foreach($results as $result)
    <div class="row" style="line-height:0.9">
        @php($name = $result->surname.' '. $result->given_name.' '. $result->other_name.'/'.date('YmdHis'))
          <p style="text-align:center;"><img src="{{asset('images/results/mak.png')}}" alt="Makerere University Logo" width="120px" style="vertical-align:middle;"></p>
          <h3 style="text-align:center; font-family:times;">MAKERERE UNIVERSITY COLLEGE OF HEALTH SCIENCES</h3>
           <h4 style="text-align:center; font-family:times;">SCHOOL OF BIOMEDICAL SCIENCES<br>
           DEPARTMENT OF IMMUNOLOGY AND MOLECULAR BIOLOGY</h4>
          <h5 style="text-align:center; font-family:times;">MOLECULAR BIOLOGY LABORATORY</h5>
          <h6 style="text-align:center; font-family:times; color:red"><b>COVID-19 TEST RESULT</b></h6>
          <hr style="height:1px; width:100%; color:#6C757D;">
    </div>
    <div  style="font-size:16px; margin-top:0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        
              <td style="width:40%">
                    <b>Patient Number: </b><font style="color:red"> {{ $result->pat_no}}</font><br>
                   <b>Laboratory ID: </b><font> {{ $result->lab_no}}</font><br>
                    <b>Reason for Testing: </b><font>{{ $result->test_reason}}</font>
            </td>
            <td style="width:20%"></td>
       
            <td style="width:40%">
                <b>Collection Date: </b><span class="upper">{{ date('d/M/Y H:i', strtotime($result->collection_date))}}</span><br>
                <b>Result Date: </b><span class="upper">{{ date('d/M/Y H:i', strtotime($result->result_added_at))}}</span><br>
                <strong>Sample Type: </strong>{{ $result->sample_type}}
            </td>
            <!--<td>-->
            <!--    <img src="{{asset('images/'.$result->patient_photo)}}" alt="user-image" class="photo"  onerror="this.onerror=null;this.src='{{asset('images/photos/20220130105722.jpg')}}';">-->
            <!--</td>-->
        </tr>
        {{--  --}}
        </table>
    </div>
    <div class="col-12 table-responsive" style="font-size:15px; margin-top:20px;">
        <table  class="table dt-responsive nowrap">
          <tbody>
          <tr class="btop">
            <td class="btop"><strong>Name:</strong> {{ $result->surname.' '. $result->given_name.' '. $result->other_name }}</td>
            <td class="btop"><strong>Gender:</strong> {{ $result->gender}}</td>
            <td class="btop"><strong>Age:</strong> {{ $result->age}} Years</td>
          </tr>
          <tr>
            <td class="btop"><strong>Date of Birth:</strong> {{$result->dob ?: 'No Available'}}</td>
            <td class="btop"><strong>Nationality:</strong>  {{ $result->nationality}}</td>
            <td class="btop"><strong>District:</strong>  {{ $result->patient_district}}</td>
          </tr>
          <tr>
            <td class="btop"><strong>Contact No:</strong>  {{$result->tell ?: 'No Available'}} </td>
            <td class="btop"><strong>{{$result->doc_type ?: 'Document'}} No:</strong> {{$result->doc_no}}</td>
            <td class="btop"><strong>Collected By:</strong> {{ $result->full_name}}</td>
          </tr>
          <tr class="btop">
            <td class="btop"><strong>Collection Site:</strong>  {{ $result->facility_name}} </td>
            <td class="btop"><strong>Type of Site:</strong> {{ $result->facility_type}}</td>
            <td class="btop"><strong>Test Method:</strong> {{ $result->test_type}}</td>
          </tr>
          <tr>
            <td class="btop"><strong>Platform:</strong>  {{ $result->platform_name}} </td>
            <td class="btop"><strong>CT Value:</strong> {{ $result->ct_value}}</td>
            <td class="btop"><strong>Platform Range:</strong>  {{ $result->range}} </td>
          </tr>
          <tr class="btop">
              <td class="btop">
                <h3>Result</h3>
                  <img width="150px" src="{{asset('images/results/stamp.png')}}" alt="">
                  <div class="text_centered"><h4>{{date('d M Y')}}</h4></div>

            </td>
            <td class="btop">
              <center>
                @if ($result->result == 'Positive')
                <h3>Result</h3>
                <img width="150px" src="{{asset('images/results/positive.png')}}" alt="">
                @elseif ($result->result == 'Negative')
                <h3>Result</h3>
                <img width="150px" src="{{asset('images/results/negative.png')}}" alt="">
                @endif
              </center>
          </td>
            <td class="btop">
                  <div style="float: right;">
                    <br>
                      {{-- {!! DNS2D::getBarcodeHTML($result->tvs_link, 'QRCODE') !!} --}}
                    {{-- {!! QrCode::size(130)->generate($result->tvs_link) !!} --}}
                   <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(100)->generate('Make me into an QrCode!')) !!} "> 
                </div>

            </td>
          </tr>

          <tr>
            <td class="btop">
                <img width="120px" src="{{asset('images/results/done_by.png')}}" alt="">
                <br>
                  <strong>Performed By: </strong> [N.A.F]
                </td>
            <td class="btop">
                <img width="120px" src="{{asset('images/results/reviewed_by.png')}}" alt="">
                  <br>
                  <strong>Reviewed By: </strong> [K.A.F]
                </td>
            <td class="btop"> 
                <img width="120px" src="{{asset('images/results/lab_manager.png')}}" alt="">
              <br>
                  <strong>Lab Manager: </strong> [K.E.G]
            </td>
         </tr>

        <tr style="border-bottom: 1px solid rgb(f, f, f); margin-top: 5px">
                <td colspan="3" class="btop">
                    <div style="display:block; border: 1px solid rgb(221, 213, 213); border-radius: 4px; padding-right:10px; padding-left:10px; line-height:1">
                        <h6>INTERPRETATION</h6>
                        @if ($result->result == 'Positive')
                        <P style="color:red">SARS-Cov-2 specific RNA is detected. An infection with SARS-Cov2 is detectable in the examined sample. An increased risk of infection for third parties is currently apparent</P>
                        @elseif ($result->result == 'Negative')
                        <P style="color:rgb(3, 117, 3)">No SARS-Cov-2 specific RNA coulbe be detected. An infection with SARS-Cov2 is not detectable in the examined sample. An increased risk of infection for third parties is currently not apparent</P>
                        @endif
                        <br>
                    </div>
                </td>

          </tr>

          </tbody>
        </table>
            <footer>
                <table width="100%">
                    <tr>
                        <td colspan="2" style="width: 80%; text-alighn:center">
                            <h6 style="color:green;  ">
                                The Laboratory is Certified by the Ministry of Health Uganda to test for COVID-19
                            </h6>
                    </td>
                        <td style="width: 20%">
                            <img width="15%" style="margin-right:18px;" src="{{asset('images/results/covid19.png')}}" alt="COVID-19" >
                        </td>
                    </tr>
                    <tr>
                        <td> <p style="text-align:center; font-size:10px; color:#4CAF50">Printed By: <font>{{ Auth::user()->name }} </font></p></td>
                        <td> <p style="text-align:center; font-size:10px; color:#4CAF50"> Print Date: {{date('l d-M-Y H:i:s')}}</font></p></td>
                        <td> <p style="text-align:center; font-size:10px; color:#4CAF50"> Printed {{$result->print_count}} time(s)</font></p></td>
                    </tr>
                </table>
                {{-- <table style="border-bottom: 0.2px solid #6C757D; width: 100%">
                  <tr>
                    <td  style="color:#6C757D">  Page <span class="page">1</span> of <span class="topage">1</span></td>
                  
                  </tr>
                </table> --}}
            </footer>




      </div>
   
    @endforeach
    @endif
    <script type='text/php'>
        if (isset($pdf)) 
        {               
            $pdf->page_text(60, $pdf->get_height() - 50, "{PAGE_NUM} of {PAGE_COUNT}", null, 12, array(0,0,0));
        }
    </script>
    </body>
</html>
