<?php

class Router {
    public function __construct() {
        $this->handleRequest();
    }

    private function handleRequest() {
        $url = isset($_GET['url']) ? $_GET['url'] : 'home';

        switch ($url) {
            case 'register':
                require_once '../Controllers/registerController.php';
                $controller = new RegisterController();
                $controller->registerUser();
                break;
            case 'updateCart':
                require_once '../Controllers/UpdateCartController.php';
                $controller = new UpdateCartController();
                $controller->updateCart();
                break;
            case 'invoice':
                require_once '../Controllers/InvoiceController.php';
                $controller = new InvoiceController();
                $controller->showInvoice();
                break;
            case 'shipping':
                require_once '../Controllers/ShippingController.php';
                $controller = new ShippingController();
                $controller->showShippingForm();
                break;
            case 'GenerateInvoice':
                require_once '../Controllers/GenerateInvoiceController.php';
                $controller = new GenerateInvoiceController();
                $controller->GenInvoice();
                break;
            case 'checkout':
                require_once '../Controllers/CheckOutController.php';
                $controller = new CheckOutController();
                $controller->CheckOut();
                break;
            case 'updatePayment':
                require_once '../Controllers/updatePaymentController.php';
                $controller = new updatePaymentController();
                $controller->updatePayment();
                break;       
            case 'sendMail':
                require_once '../Controllers/sendMailController.php';
                $controller = new sendMailController();
                $controller->sendMail();
                break;    
            case 'invoicePDF':
                require_once '../Controllers/invoicePDFController.php';
                $controller = new invoicePDFController();
                $controller->genPDF();
                break;  
            case 'setOrderID':
                require_once '../Controllers/setOrderIDController.php';
                $controller = new setOrderIDController();
                $controller->setOrderID();
                break;  
            case 'pastOrder':
                require_once '../Controllers/pastOrderController.php';
                $controller = new pastOrderController();
                $controller->pastOrder();
                break;  
            case 'paymentHistory':
                require_once '../Controllers/paymentHistoryController.php';
                $controller = new paymentHistoryController();
                $controller->paymentHistory();
                break;  
            case 'handleShippingSubmission':
                require_once '../Controllers/ShippingController.php';
                $controller = new ShippingController();
                $controller->handleShippingSubmission();
                break;  
            case 'cart':
                require_once '../Controllers/CartController.php';
                $controller = new CartController();
                $controller->displayCart();
                break; 
            case 'error':
                require_once '../Controllers/ErrorController.php';
                $controller = new ErrorController();
                $controller->error();
                break;  
            default:
                require_once '../Controllers/HomeController.php';
                $controller = new HomeController();
                $controller->index();
                break;
        }
    }
}
?>
