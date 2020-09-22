<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PDF Library
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Muhanz
 * @license         MIT License
 * @link            https://github.com/hanzzame/ci3-pdf-generator-library
 *
 */

require_once(dirname(__FILE__) . '/dompdf2/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    public function create($html,$filename, $paper_o = "potrait", $paper = "A4")
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $context = stream_context_create([ 
            'ssl' => [ 
                'verify_peer' => FALSE, 
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE 
            ] 
        ]);
        $dompdf->set_paper($paper, $paper_o);
        $dompdf->setHttpContext($context);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream($filename.'.pdf');
  }
  
  // fandu costm 27-08-2018
  public function create_costum($html,$filename, $paper_o, $paper)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $context = stream_context_create([ 
            'ssl' => [ 
                'verify_peer' => FALSE, 
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE 
            ] 
        ]);
        $dompdf->set_paper($paper, $paper_o);
        $dompdf->setHttpContext($context);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream($filename.'.pdf');
  }
}