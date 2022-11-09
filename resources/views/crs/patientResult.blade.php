<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="LabPlus is an online application for Laboratory test requests" name="description">
    <meta content="MUH" name="Makerere University Hospital"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <!-- third party css -->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="light-style">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
    <style type="text/css">
        .wrapper {
        width: 70%;
        height: auto;
        margin: 10px auto;
        border: 1px solid #cbcbcb;
        background: white;
      }

    .upper{text-transform: uppercase;}
      .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
      }

        footer {
        font-size: 12px;
        color: #000;
        text-align: center;
        margin-top:  4px;
      }
      #bottom {
                position: absolute;
                bottom:30;
                /* left:0;                          */
            }
        .text_centered {
        position: absolute;
        top: 68%;
        left: 26%;
        transform: translate(-50%, -50%);
        color: red
        }
        header {
        font-size: 12px;
        color: #000;
        text-align: center;
        margin-bottom: 12px
      }

      @page {
        size: A4;
        margin: 11mm 17mm 17mm 17mm;
        @bottom-right {
          content: counter(page) " of " counter(pages);
         }
      }

      .doc {
        writing-mode: vertical-rl;
         position: absolute;
        left: -15px;
        bottom: 0px;
        z-index: 1;
      }
      .photo {
        display: block;
        border: 2px solid #ccc;
         border-radius: 4px;
        margin-left: auto;
        width: 120px;
        height: 160px;
        }
      @media print {
        footer {
          position: fixed;
          bottom: 0;
        }
        .text_centered {
        position: absolute;
        top: 59%;
        left: 19%;
        /* transform: translate(-50%, -50%); */
        color: red
        }
      .wrapper{
         width: 100%;
        height: auto;
        margin: 2px auto;
        margin-top: -12px;
        border: 0px ;
        background: white;
        }
        .button {
          display: none;
        }
      header {
          position: fixed;
          top: 0;
           text-align: right;
        }

        .doc {
        writing-mode: vertical-rl;
         position:  fixed;
        left: -15px;
        bottom: 19px;
        z-index: 1;
      }
        .content-block, p {
          page-break-inside: avoid;
        }

        html, body {
          width: 210mm;
          height: 297mm;
        }
      }
       .page-break {
                page-break-after: always;
            }
      </style>
      <script>
      window.print();
    //  window.onmousemove = function() {
    //   window.close();}
     </script>

</head>
<body  style="background-color: #fff">
    <!-- end row-->

            <section class="wrapper" id="content">
            @if(count($results)>0)
            @foreach($results as $result)
                <!-- title row -->
                <div class="row">
@php($name = $result->surname.' '. $result->given_name.' '. $result->other_name.'/'.date('YmdHis'))
                    <p style="text-align:center;"><img src="{{asset('images/results/mak.png')}}" alt="Makerere University Logo" width="150px" style="vertical-align:middle;"></p>
                    <h3 style="text-align:center; font-family:times;">MAKERERE UNIVERSITY COLLEGE OF HEALTH SCIENCES</h3><br>
                     <h4 style="text-align:center; font-family:times;">SCHOOL OF BIOMEDICAL SCIENCES<br>
                     DEPARTMENT OF IMMUNOLOGY AND MOLECULAR BIOLOGY</h4>
                    <h5 style="text-align:center; font-family:times;">MOLECULAR BIOLOGY LABORATORY</h5>
                    <h6 style="text-align:center; font-family:times; color:red"><b>COVID-19 TEST RESULT</b></h6>
                    <hr style="height:1px; width:100%; color:#6C757D;">
                </div>
                <!-- info row -->
                <div  style="font-size:15px; margin-top:0px;">
                    <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
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
                <!-- /.row -->

                <!-- Table row -->
                <div class="row" style="background-color: #fff">
                  <div class="col-12 table-responsive" style="font-size:15px;">
                    <table  class="table dt-responsive nowrap" style="line-height:0.9; margin-top: -10px" >
                      <tbody>
                      <tr>
                        <td><strong>Name:</strong> {{ $result->surname.' '. $result->given_name.' '. $result->other_name }}</td>
                        <td><strong>Gender:</strong> {{ $result->gender}}</td>
                        <td><strong>Age:</strong> {{ $result->age}} Years</td>
                      </tr>
                      <tr>
                        <td><strong>Date of Birth:</strong> {{$result->dob ?: 'No Available'}}</td>
                        <td><strong>Nationality:</strong>  {{ $result->nationality}}</td>
                        <td><strong>District:</strong>  {{ $result->patient_district}}</td>
                      </tr>
                      <tr>
                        <td><strong>Contact No:</strong>  {{$result->tell ?: 'No Available'}} </td>
                         <td><strong>{{$result->doc_type ?: 'Document'}} No:</strong> {{$result->doc_no}}</td>
                        <td><strong>Collected By:</strong> {{ $result->swabber.' '.$result->collectedbyfn}}</td>
                      </tr>
                      <tr>
                        <td><strong>Collection Site:</strong>  {{ $result->facility_name}} </td>
                        <td><strong>Type of Site:</strong> {{ $result->facility_type}}</td>
                        <td><strong>Test Method:</strong> {{ $result->test_type}}</td>
                      </tr>
                      <tr>
                        <td><strong>Platform:</strong>  {{ $result->platform_name}} </td>
                        <td><strong>CT Value:</strong> {{ $result->ct_value}}</td>
                        <td><strong>Platform Range:</strong>  {{ $result->range}} </td>
                      </tr>

                     

                      <tr>
                          <td>
                              <img width="240px" src="{{asset('images/results/stamp.png')}}" alt="">
                              <div class="text_centered"><h4>{{date('d M Y')}}</h4></div>

                        </td>
                        <td>
                          <center>
                            @if ($result->result == 'Positive')
                            <!--<h2>Result <br> <strong style='color:rgb(232, 4, 4)'>{{$result->result}}</strong></h2>-->
                            <h3>Result<h/3><br>
                            <img width="200px" src="{{asset('images/results/positive.png')}}" alt="">
                            @elseif ($result->result == 'Negative')
                            <h3>Result<h/3><br>
                            <!--<h2>Result  <br> <strong style='color:rgb(4, 130, 25)'>{{$result->result}}</strong></h2>-->
                            <img width="200px" src="{{asset('images/results/negative.png')}}" alt="">
                            @endif
                          </center>
                      </td>
                        <td>
                              <div style="float: right;">
                                  {{-- {!! DNS2D::getBarcodeHTML($result->tvs_link, 'QRCODE') !!} --}}
                                {!! QrCode::size(130)->generate($result->tvs_link) !!}
                            </div>

                        </td>
                      </tr>

                      <tr>
                        <td>
                            <img width="150px" src="{{asset('images/results/done_by.png')}}" alt="">
                            <br>
                              <strong>Performed By: </strong> [N.A.F]
                            </td>
                        <td>
                            <img width="150px" src="{{asset('images/results/reviewed_by.png')}}" alt="">
                              <br>
                              <strong>Reviewed By: </strong> [K.A.F]
                            </td>
                        <td>
                            <img width="150px" src="{{asset('images/results/lab_manager.png')}}" alt="">
                          <br>
                              <strong>Lab Manager: </strong> [K.E.G]
                            </td>
                     </tr>
    
                    <tr style="border-bottom: 1px solid rgb(f, f, f);">
                            <td colspan="3">
                                <div style="display:block; border: 1px solid rgb(221, 213, 213); border-radius: 4px; padding-right:10px; padding-left:10px; line-height:1.2">
                                    <h6>INTERPRETATION</h6>
                                    @if ($result->result == 'Positive')
                                    <P>SARS-Cov-2 specific RNA is detected. An infection with SARS-Cov2 is detectable in the examined sample. An increased risk of infection for third parties is currently apparent</P>
                                    @elseif ($result->result == 'Negative')
                                    <P>No SARS-Cov-2 specific RNA coulbe be detected. An infection with SARS-Cov2 is not detectable in the examined sample. An increased risk of infection for third parties is currently not apparent</P>
                                    @endif
                                    <br>
                                </div>
                            </td>

                      </tr>

                      </tbody>
                    </table>
                        <footer>
                            <table width="100%" style="margin-top: -120px" >
                                <tr>
                                    <td colspan="2" style="width: 80%;">
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
                            <table style="border-bottom: 0.2px solid #6C757D; width: 100%">
  <tr>
    <td  style="color:#6C757D">  Page <span class="page">1</span> of <span class="topage">1</span></td>
   
  </tr>
</table>
                        </footer>




                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                @endforeach
                @endif
              </section>


        {{-- <button class="button" onclick="window.print()">Print</button> --}}

        <Script>
//var name = <?php echo $name; ?>;
            let doc = new jsPDF('p','pt','a4');
            doc.setFontSize(22);
            doc.setTextColor(255, 0, 0);
            doc.text(20, 20, 'This is a title');
            doc.margin(1);
            doc.setFontSize(16);
            doc.setTextColor(0, 255, 0);
            doc.text(20, 30, 'This is some normal sized text underneath.');
            doc.addHTML(document.body,function() {
                doc.save('Print');
            });
             </Script>
</body>
</html>
