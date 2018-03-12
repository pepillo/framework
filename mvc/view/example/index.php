<?php
require_once(DB_MYSQL.'initialize_db.php');
require_once(THIRD_PARTY_DIR.'dompdf/autoload.inc.php');
use Dompdf\Dompdf;

require_once(THIRD_PARTY_DIR.'csv-8.2.3/autoload.php');
use League\Csv\Writer;

require_once(PHPMAILER);
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

#This is called at the start (before) the call of any app_event
function app_start($template, $values){
    global $db;

    $template->menu->addMenuHeader('MAIN NAVIGATION');
    $template->menu->addMenuElement('Dashboard', 'dashboard', 'r=home&a=dashboard', null);

    $template->menu->addMenuHeader('EXAMPLE NAVIGATION');
    $template->menu->addMenuElement('Example Landing', 'star', 'r=example&a=default', null);

    $template->menu->addMenuElement('Basic Layout', 'map-o', 'r=example&a=basic_layout', null);
    $template->menu->addMenuElement('Form', 'list-alt', 'r=example&a=form', null);
    $template->menu->addMenuElement('Table', 'table', 'r=example&a=table', null);
    $template->menu->addMenuElement('PHP Info', 'table', 'r=example&a=phpinfo', null);

    $template->menu->addMenuElement('PDF Example', 'list', [
        ['label' => 'PDF Header Test','href' => 'r=example&a=pdf_header_test'],
        ['label' => 'PDF 1','href'           => 'r=example&a=pdf_test_1'],
        ['label' => 'PDF JS 1','href'        => 'r=example&a=pdf_js_1'],
        ['label' => 'PDF JS 2','href'        => 'r=example&a=pdf_js_2'],
        ['label' => 'PDF JS 3','href'        => 'r=example&a=pdf_js_3'],
    ]);

    $template->menu->addMenuElement('CSV Example', 'list', [
        ['label' => 'CSV Test 1','href' => 'r=example&a=test_csv'],
    ]);

    $template->menu->addMenuElement('PHP Mailer', 'list', [
        ['label' => 'Mail Example','href'   => 'r=example&a=phpmailer'],
        ['label' => 'Mail New Class','href' => 'r=example&a=phpmailer_new_class'],
        ['label' => 'Mail Static','href'    => 'r=example&a=phpmailer_static'],
    ]);
}

#If no action found use default
function app_event_default($template, $values){
    $template->write('<b>Example Landing</b>');
}

function app_event_form($template, $values){
    $template->setTitle('Form');
    $template->setHeader('Form Example', 'Yes this is a form');
    $template->setBreadcrumb(['Example'=>'r=example&a=default',
                              'Form'=>null]);

    if(isset($values['some_id'])){
         $template->write($values, true);#true parameter -> echo debug
         return;
    }

    $data = [
        'some_id' => '12345',
        'name' => 'Jose Delgado',
        'email' => 'jose.delgado@gmail.com',
        'phone' => '5555555555',
        'location' => 'camuy',
        'money' => '9999',
        'slider' => '500;700',
        'note' => 'Some Lorem',
        'bool' => '1',
    ];

    $container = ui_container::newContainer();
    $container->setTitle('This is a Form');

    $item = new ctr_hidden('r', 'example');
    $container->appendItem($item);

    $item = new ctr_hidden('a', 'form');
    $container->appendItem($item);

    $item = new ctr_hidden('some_id', $data['some_id']);
    $container->appendItem($item);

    $item = new ctr_label('ID', $data['some_id']);
    $container->appendItem($item);

    $item = new ctr_text('Name', 'name', $data['name'], 'Input Name...');
    $container->appendItem($item);

    $item = new ctr_text_icon('at', 'email', 'Email', $data['email'], 'Input Email...');
    $container->appendItem($item);

    $item = new ctr_text_icon('phone', 'phone', 'Phone', $data['phone'], 'Input Phone...', '(999) 999-9999');
    $container->appendItem($item);

    $dropdown = ['camuy'=>'Camuy','hatillo'=>'Hatillo','arecibo'=>'Arecibo'];
    $item = new ctr_dropdown('Location', 'location', $data['location'], $dropdown);
    $container->appendItem($item);

    $item = new ctr_currency('Money', 'money', $data['money'], 'width:100px;');
    $container->appendItem($item);

    $item = new ctr_slider('Slider', 'slider', $data['slider'], [300,850]);
    $container->appendItem($item);

    $item = new ctr_text_box('Note', 'note', $data['note'], 'Enter a description...');
    $container->appendItem($item);

    $item = new ctr_bool('Bool', 'bool', $data['bool']);
    $container->appendItem($item);

    $container->addSubmitBtn('Submit Button');

    $template->write($container);
}

function app_event_pdf($template, $values){
    $template->write('<b>Table Landing</b>');
}

function app_event_table($template, $values){
    $template->setTitle('Basic Table');
    $template->setHeader('Table Example', 'Yes this is a table');
    $template->setBreadcrumb(['Example'=>'r=example&a=default',
                               'Table'=>null]);

    $container = ui_container::newContainer();
    $container->setTitle('This is a Table');

    $table = ui_table::newTable('table1');

    $table->addHeader('name', 'Name');
    $table->addHeader('email','Email');
    $table->addHeader('phone','Phone');

    $table->addAction('pencil', 'r=not_exist&a=not_exist&uid=uid%');
    $table->addAction('trash',  'r=not_exist&a=not_exist&uid=uid%');

    $tr = ['name'=>'Jose Delgado', 'email'=>'jose.delgado@gmail.com', 'phone'=>'555-555-5555'];
    $table->addRow($tr);

    $tr = ['name'=>'John Delgado', 'email'=>'john.delgado@gmail.com', 'phone'=>'555-777-5555'];
    $table->addRow($tr);

    $container->appendItem($table);

    $template->write($container);
}

function app_event_basic_layout($template, $values){
    $template->setTitle('Basic Layout');
    $template->setHeader('Basic Layout Example', 'Yes this is a basic layout');
    $template->setBreadcrumb(['Example'=>'r=example&a=default',
                               'Layout'=>null]);

    $container = ui_container::newContainer();
    $container->setTitle('This is a container');

    $container->appendItem("<div style='height: 300px;'>Body Content</div>");
    $container->addSubmitBtn('Button Footer');

    $template->write($container);
}

function app_event_pdf_header($template, $values){
    global $db;
    $id = $values['content_id'];

    $pdf = $db->where("id", $id)->getOne('pdf');

    $content = $pdf['content'];

    header('Cache-Control: public');
    header('Content-Type: application/pdf');
    header('filename="some-file.pdf"');
    //header('Content-Length: '.mb_strlen($content));

    echo $content;
}

function app_event_pdf_header_test($template, $values){
    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h1>hello world</h1>');
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $content = $dompdf->output();

    header('Cache-Control: public');
    header('Content-Type: application/pdf');
    header('filename="some-file.pdf"');
    //header('Content-Length: '.mb_strlen($content));

    echo $content;
}

function app_event_pdf_test_1($template, $values){
    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h1>hello world</h1>');
    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');
    // Render the HTML as PDF
    $dompdf->render();
    // Output the generated PDF to Browser
    //$dompdf->stream();
    //$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
    //exit(0);
    //$dompdf->output();
    //$dompdf->outputHtml();
    //$template->write($dompdf->output(),true);
    $x = '<iframe type="application/pdf"
                width="95%"
                height="95%"
                src="data:application/pdf;">
          Oops, you have no support for iframes.
        </iframe></p>';

    $y = '<embed width="600" height="450" src="?r=home&a=pdf&content='.base64_encode($dompdf->output()).'" type="application/pdf"></embed>';

    #or



    $template->write($y);
    //$template->write($x);
}

function app_event_pdf_js_1($template, $values){

    $js = ' <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
            <script>
            // Default export is a4 paper, portrait, using milimeters for units
            var doc = new jsPDF()

            doc.text("Hello world!", 10, 10)
            doc.save("a4.pdf")
            </script>';
    $template->write($html.$js);
}

function app_event_pdf_js_2($template, $values){
    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h1>hello world</h1>');
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $html= '<!-- for legacy browsers add compatibility.js -->
            <!-- <script src="//mozilla.github.io/pdf.js/web/compatibility.js"></script> -->

            <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>

            <h1>PDF.js \'Hello, base64!\' example</h1>

            <canvas id="the-canvas"></canvas>';

            $js = " <script>
                    // atob() is used to convert base64 encoded PDF to binary-like data.
                    // (See also https://developer.mozilla.org/en-US/docs/Web/API/WindowBase64/
                    // Base64_encoding_and_decoding.)
                    var pdfData = atob('".base64_encode($dompdf->output())."');

                    // Disable workers to avoid yet another cross-origin issue (workers need
                    // the URL of the script to be loaded, and dynamically loading a cross-origin
                    // script does not work).
                    // PDFJS.disableWorker = true;

                    // The workerSrc property shall be specified.
                    PDFJS.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

                    // Using DocumentInitParameters object to load binary data.
                    var loadingTask = PDFJS.getDocument({data: pdfData});
                    loadingTask.promise.then(function(pdf) {
                      console.log('PDF loaded');

                      // Fetch the first page
                      var pageNumber = 1;
                      pdf.getPage(pageNumber).then(function(page) {
                        console.log('Page loaded');

                        var scale = 1;
                        var viewport = page.getViewport(scale);

                        // Prepare canvas using PDF page dimensions
                        var canvas = document.getElementById('the-canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        // Render PDF page into canvas context
                        var renderContext = {
                          canvasContext: context,
                          viewport: viewport
                        };
                        var renderTask = page.render(renderContext);
                        renderTask.then(function () {
                          console.log('Page rendered');
                        });
                      });
                    }, function (reason) {
                      // PDF loading error
                      console.error(reason);
                    });
                    </script>";
    $template->write($html.$js);
}

function app_event_pdf_js_3($template, $values){
    global $db;

    $dompdf = new Dompdf();
    $dompdf->loadHtml('<h1>Hello world, I am Here!</h1>');
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $id = $db->insert('pdf', ["content" => $dompdf->output()]);

    $js = '<script>
            if(PDFObject.supportsPDFs){
               console.log("Yay, this browser supports inline PDFs.");
            } else {
               console.log("Boo, inline PDFs are not supported by this browser");
            }
            </script>

            <style>
            .pdfobject-container { height: 500px;}
            .pdfobject { border: 1px solid #666; }
            </style>

            <div id="example1"></div>

            <script>PDFObject.embed("?r=example&a=pdf_header&content_id='.$id.'", "#example1");</script>

            <a href="?r=example&a=pdf_header&content_id='.$id.'">Link PDF</a>';

    $template->write($js);

    //$template->write('?r=example&a=pdf_header&content='.(serialize($dompdf)), true);
    //$template->write($content, true);
}

function app_event_test_csv($template, $values){
  header('Content-Type: text/csv; charset=UTF-8');
  header('Content-Disposition: attachment; filename="name-for-your-file.csv"');

  $rows = [
      [1, 2, 3],
      ['foo', 'bar', 'baz'],
      "'john','doe','john.doe@example.com'",
  ];

  $writer = Writer::createFromFileObject(new SplTempFileObject());
  $writer->insertAll($rows); //using an array
  $writer->insertAll(new ArrayIterator($rows)); //using a Traversable object
  $writer->output();

  exit;
}

function app_event_phpmailer($template, $values){
    $template->write('Work! Email Sent to fullmetalpepillo@gmail.com & jose.delgado12@upr.edu<hr>');

    //return;

    $mail = new PHPMailer(/*true*/);                              # Passing `true` enables exceptions

    try {
        #Server settings
        //$mail->SMTPDebug = 2;                                 # Enable verbose debug output
        //$mail->isSMTP();                                      # Set mailer to use SMTP
        //$mail->Host = 'smtp1.example.com;smtp2.example.com';  # Specify main and backup SMTP servers
        //$mail->SMTPAuth = true;                               # Enable SMTP authentication
        //$mail->Username = 'user@example.com';                 # SMTP username
        //$mail->Password = 'secret';                           # SMTP password
        //$mail->SMTPSecure = 'tls';                            # Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 587;                                    # TCP port to connect to

        #Recipients
        $mail->setFrom('realtor@realtorheart.com', 'Mailer');
        $mail->addAddress('fullmetalpepillo@gmail.com', 'Fullmetal User');      # Add a recipient
        $mail->addAddress('jose.delgado12@upr.edu');                            # Name is optional
        //$mail->addReplyTo('realtor@realtorheart.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        #Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         # Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    # Optional name

        #Content
        $mail->isHTML(true);                                  # Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $template->write('Message has been sent');
    } catch (Exception $e) {
        $template->write('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
    }
}

function app_event_phpmailer_new_class($template, $values){
    $template->write('Work! Email Sent to jose.delgado12@upr.edu NEW CLASS<hr>');

    $mail = new php_mail();
    $mail->mail('jose.delgado12@upr.edu', 'Test Subject', 'Test Message');

    if(!$mail->error){
        $template->write('No Error');
    } else {
        $template->write('Yes Error');
    }

    $template->write($mail, true);
}

function app_event_phpmailer_static($template, $values){
    $template->write('Work! Email Sent to jose.delgado12@upr.edu STATIC<hr>');

    if(!php_mail::send('jose.delgado12@upr.edu', 'Test Subject Static', 'Test Message Static')){
        $template->write('Yes Error');
    } else {
        $template->write('No Error');
    }
}

function app_event_phpinfo($template, $values){
    phpinfo();
    exit;
}

#This is called at the end (after) the call of any app_event
function app_end(){

}

#Template/Framework variable configuration
function initialize_application(&$properties){
    //$properties->name = 'dashboard';
    //$properties->uid = 'rh_dashboard';
    //$properties->use_view_helpers = 'scr_helper_*.php';
    #Require auth (LOGIN)
    $properties['use_auth'] = true;

    return true;
}
?>
