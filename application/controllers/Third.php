<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Third extends CI_Controller {
  public function __construct()
    {
        parent::__construct();         
        $this->load->model('api/baby_model');  
        include_once APPPATH.'/third_party/mpdf/mpdf.php';    
    }

    public function secondPdf()
    {
        error_reporting(0); 
        $html.= '  <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
           span.dotted{
              border-bottom: 1px dashed #000;
              text-decoration: none; 
            }
            .headingFont{
              font-size:15px;

            }
            .contentPadding{
               padding:5px;
               border: 1px solid black;
            }table {
                border-collapse: collapse;
              }
              .tableSecContent{
                font-size: 13px;
                padding:5px;
              }tr{
                padding:5px;
              }
        </style>
    </head>
      <body>
          <div style="width:100%;">
                <!-- set heading of pdf form -->
                <h3 style="text-align: center;margin: auto;">BABY'."'".'S INFORMATION :At Birth</h3><br>
                  <div style="border:1px solid;" >
                  <table width="100%" >
                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                          Mother'."'".'s Age.........Yrs.
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         Mother'."'".'s Wt..........Kgs.
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Age at Marriage........Yrs.
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Consaguinity: Yes/No
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Birth Spacing: < 1Yr/1-2Yr/>2-3Yr/>3Yr/Not Applicable
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                        Gravida:........
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         Para:.......
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       Live Birth:....
                      </td>
                      <td style="border-left-style:hidden !important;" class="tableSecContent" valign="top">
                      Abortion:.......
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         LMP:../../..
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         EDD:../../..
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Gestation Weeks:........
                      </td>
                    </tr>



                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         Antenatal Visits
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         :None / 1 / 2 / 3 / 4
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        T.T Doses: None / 1 / 2
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         Hb
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                        :........
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Blood Group:........
                      </td>
                    </tr>

                  </table>
                  </div>



                <!-- set heading of pdf form --><br>
                <h3 style="text-align: center;margin: auto;">BABIES INFORMATION : On Admission</h3><br>
                  <div style="border:1px solid;" >
                  <table width="100%" style="height:100px;">
                    <tr>
                      <td class="tableSecContent" style="height:100px;" valign="top">
                         PRESENTINGS COMPLAINTS:
                      </td>
                    </tr>

                  </table>
                  </div>







                <!-- set heading of pdf form --><br>
                <h3 style="text-align: center;margin: auto;">GENERAL EXAMINATION</h3><br>
                  <div style="border:1px solid;" >
                  <table width="100%" >
                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                          Mother'."'".'s Age.........Yrs.
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         Mother'."'".'s Wt..........Kgs.
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Age at Marriage........Yrs.
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Consaguinity: Yes/No
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Birth Spacing: < 1Yr/1-2Yr/>2-3Yr/>3Yr/Not Applicable
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                        Gravida:........
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         Para:.......
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       Live Birth:....
                      </td>
                      <td style="border-left-style:hidden !important;" class="tableSecContent" valign="top">
                      Abortion:.......
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         LMP:../../..
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         EDD:../../..
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Gestation Weeks:........
                      </td>
                    </tr>



                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         Antenatal Visits
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         :None / 1 / 2 / 3 / 4
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        T.T Doses: None / 1 / 2
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         Hb
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                        :........
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        Blood Group:........
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       PIH
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="tableSecContent" valign="top">
                        :No Yes [Hypertension/Pre Eclampsia/Eclampsia]
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       Drug
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        :No [ ] Yes [ ] (...................)
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="tableSecContent" valign="top">
                        Radiation: Yes [ ] No [ ]
                      </td>
                    </tr>



                    <tr>
                      <td style="border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       Illness
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="tableSecContent" valign="top">
                        :Malaria/TB/jaundice/Rash with fever/U.T.I/Syphills/Other(...................)
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         APH
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         : Yes [ ] No [ ]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        GDM: Yes [ ] No [ ]
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       Thyroid
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="tableSecContent" valign="top">
                        :Euthyroid(N)/Hypothyroid/Hyperthyroid/Not Known
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         VDRL
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         :Not Done / +Ve / -Ve 
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        HbsAg:Not Done / +Ve / -Ve 
                      </td>
                    </tr>




                    <tr>
                      <td style="border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       Illness
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="tableSecContent" valign="top">
                        :Malaria/TB/jaundice/Rash with fever/U.T.I/Syphills/Other(...................)
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         APH
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         : Yes [ ] No [ ]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        GDM: Yes [ ] No [ ]
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       Thyroid
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="tableSecContent" valign="top">
                        :Euthyroid(N)/Hypothyroid/Hyperthyroid/Not Known
                      </td>
                    </tr>


                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         VDRL
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         :Not Done / +Ve / -Ve 
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        HbsAg:Not Done / +Ve / -Ve 
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                       Illness
                      </td>
                      <td style="border-left-style:hidden; !important;" colspan="3" class="tableSecContent" valign="top">
                        :Malaria/TB/jaundice/Rash with fever/U.T.I/Syphills/Other(...................)
                      </td>
                    </tr>

                    <tr>
                      <td style="border-right-style:hidden !important;" class="tableSecContent" valign="top">
                         APH
                      </td>
                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" class="tableSecContent" valign="top">
                         : Yes [ ] No [ ]
                     </td>

                      <td style="border-left-style:hidden;border-right-style:hidden; !important;" colspan="2" class="tableSecContent" valign="top">
                        GDM: Yes [ ] No [ ]
                      </td>
                    </tr>

                    <tr>
                      <td  class="tableSecContent" colspan="4" valign="top">
                         Other Significant Information:
                      </td>
                    </tr>

                  </table>
                  </div>
          </div>
      </body>
  </html>'; 

        $pdfFilePath =  INVOICE_DIRECTORY."Third.pdf";
        $mpdf =  new mPDF('utf-8', 'A4-R');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

        $mpdf->WriteHTML($PDFContent);

        $mpdf->Output($pdfFilePath, "F"); 
        //return "b_".$getBabyFileId['id']."_weigth.pdf";
    }


}