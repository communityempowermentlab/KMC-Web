<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Four extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/baby_model');  
        include_once APPPATH.'/third_party/mpdf/mpdf.php';    
    }

    public function fourPdf()
    {
        error_reporting(0); 
        $html.= '<html>
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
           span.dotted{
              border-bottom: 1px dashed #000;
              text-decoration: none; 
            }
            .contentPadding{
               padding:5px;
               border: 1px solid black;
            }table {
                border-collapse: collapse;
              }
              .tableSecContent{
                font-size: 12px;
                padding-left:5px;
              }td{
                height: 30px !important;
              }td {
                padding: 5px;
              }
        </style>
    </head>
      <body>
          <div style="width:100%;">
                <!-- set heading of pdf form -->
                <h3 style="text-align: center;">SYSTEMIC EXAMINATION</h3>
                  <div style="border:1px solid;padding:8px !important;">
                  <table width="100%" >

                    <tr>
                      <td style="border-right-style:hidden;width:30%; !important;" class="tableSecContent" valign="top">
                          CVS 
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="tableSecContent" colspan="2" valign="top">
                        :...............................................................................................................................
                     </td>
                    </tr>

                              <tr>
                                <td style="border-right-style:hidden;width:30%; !important;" class="tableSecContent" valign="top">
                                    RESPIRATORY 
                                </td>
                                <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="tableSecContent" colspan="2" valign="top">
                                    :...............................................................................................................................
                               </td>
                              </tr>

                    <tr>
                      <td style="border-right-style:hidden;width:30%; !important;" class="tableSecContent" valign="top">
                          PER ABDOMEN 
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="tableSecContent" colspan="2" valign="top">
                        :...............................................................................................................................
                     </td>
                    </tr>

                              <tr>
                                <td style="border-right-style:hidden;width:30%; !important;" class="tableSecContent" valign="top">
                                    CNS 
                                </td>
                                <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="tableSecContent" colspan="2" valign="top">
                                    :...............................................................................................................................
                               </td>
                              </tr>

                    <tr>
                      <td style="border-right-style:hidden;width:30%; !important;" class="tableSecContent" valign="top">
                          OTHER SIGNIFICANT FINDING 
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden;width:70%; !important;" class="tableSecContent" colspan="2" valign="top">
                        :...............................................................................................................................
                     </td>
                    </tr>
                  </table>
                  </div>

        <!-- second section heading of pdf form -->

                <h3 style="text-align: center;">TREATMENT ADVISED : On Admission</h3>
                  <div style="border:1px solid;padding:8px !important;">
                    <table width="100%" >
                      <tr>
                        <td style="height:120px; !important;" class="tableSecContent" valign="top">
                        </td>
                      </tr>
                    </table>
                  </div>

        <!-- Third section heading of pdf form -->

                <h3 style="text-align: center;">INVESTIGATIONS ADVISED : On Admission</h3>
                  <div style="border:1px solid;padding:8px !important;">
                    <table width="100%" >
                      <tr>
                        <td style="height:60px; !important;" class="tableSecContent" valign="top">
                        </td>
                      </tr>
                    </table>
                  </div>

                    <div width="100%" style="" >

                    <div width="30%" style="float:left;" >
                      <br>
                      <img src="'.base_url().'assets/helth.png" style="width: 80px;height: 100px;"><br/>
                          <span style=""> Foot Print of Newborn<br/>
                          (Left Foot) </span>
                    </div>
                    <div width="70%" style="float:right;">
                    <p style="text-align:right;">Doctor'."'".'s Name and Signature</p>
                    <b style="text-align:center;">सहमति पत्र</b><br/>
                    हमें डॉक्टर द्वारा बता दिया गया है कि शिशु गंभीर रूप से बीमार है एवं उपचार के दौरान होने वाली जटिलताओं से हमें अवगत करा दिया गया है तथा हमें पूर्ण रूप से विदित है कि उपचार के दौरान समस्याए उत्पन्न हो सकती हैं| इन सभी खतरों से अवगत होने के बाद भी हम हमारे बच्चे को एस. एन. सी. यू. जिला चिकित्सालय में उपचार हेतु भर्ती कराने के लिए सहमत हैं|
                     <p style="text-align:right;">अभिभावक के हस्ताक्षर</p>
                    </div>
                           

                    </div>


        <!-- Fourth section heading of pdf form -->

                <h3 style="text-align: center;">FINAL OUTCOME</h3>
                  <div style="border:1px solid;padding:8px;text-align:center; !important;">
                    <span>Successfully Discharged/Left Against medical Advice/Referred/Expired</span>
                  </div>

                <h3 style="text-align: center;">In Case of Death : Mention Cause of Death<span style="font-size:12px;">(The most Relevent Single Indication)<span></h3>
                  <div style="border:1px solid;padding:8px !important;">
                    <table width="100%" >
                      <tr>
                        <td style="height:60px; !important;" class="tableSecContent" valign="top">
                        </td>
                      </tr>
                    </table>
                  </div>

          </div>
      </body>
  </html>'; 

        $pdfFilePath =  INVOICE_DIRECTORY."Four.pdf";

        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        //return "b_".$getBabyFileId['id']."_weigth.pdf";
    }


}