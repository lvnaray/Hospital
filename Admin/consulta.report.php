<?php
require_once 'sistema.controller.php';
require_once 'consulta.controller.php';
$sistema = new Sistema;
$consultas = new Consulta;
$sistema->verificarRoles('Doctor');
$id_consulta = $_GET['id_consulta'];
$datos = $consultas->readOne($id_consulta);

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {

    $content = "
    <h1>Receta médica</h1>
    <h3>NOMBRE DOCTOR: </h3>
    <h4>" . $datos[0]['doctor'] . "</h4>";
    $content .= "
    <h3>NOMBRE PACIENTE: </h3>
    <h4>" . $datos[0]['paciente'] . "</h4>";
    $content .= "<table>
    <tr>
    <th>Fecha   </th>
    <th>Padecimiento  </th>
    <th>Tratamiento  </th>
    </tr>";
    foreach ($datos as $key => $dato) {
        $content .= "<tr>
        <td>" . $dato['fecha'] . "</td>
        <td>" . $dato['padecimiento'] . "</td>
        <td>" . $dato['tratamiento'] . "</td>
        </tr>";
    }
    $content .= "</table>";
    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    ob_end_clean();
    $html2pdf->output('receta.pdf', 'I');
} catch (Html2PdfException $e) {

    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
?>