<?php
class pages 
{
    static function invoice ($reference, $info, $shipping)
    {
        switch ($info) 
        {
            case 1:
                $page1='<!--Upper section--><header>
        <nav class="navbar ">
               <header class="nabvar-mobile is-size-5-mobile">
               <form action="index.php" style="padding-top:50px">
                   <button class="delete is-large"></button>
               </form>
                   <a class="navbar-mobile-link has-text-white" href="#" id="btn-mobile"><i></i></a>
                   <a class="navbar-mobile-link has-text-white" style="padding-top:50px">Invoice ID:'.$reference.'</a>
                   <a class="navbar-mobile-link has-text-white" href="invoice.php?List=View"><i></i></a>
               </header>
           </nav>
           <nav class="navbar-top">
               <ul class="navbar-top-ul">
                   <li class="navbar-top-item">
                      <a class="delete is-large" href="invoice.php?List=View"></a>
                   </li>
               </ul>
           </nav>
       <!--Banner-->
       <div class="banner-second">
           <div class="banner-container ">
               <div class="page-content container">
                   <div class="block">
                       <div class="row">
                           <div class="col-12">
                               <div class="text-center text-150" style=""> 
                               <i class="fa fa-book fa-2x text-success-m2 mr-1"></i> 
                               <span class="text-default-d3" style="color:#2F3A67">Invoice ID: '.$reference.'</span>
                               </div>
                           </div>
                       </div>
                   </div>	
               </div>
           </div>
       </div> 
       <div href="invoice.php?View='.$reference.'" style=" display: flex; align-items: center; justify-content: center;">
       <button class="button is-success" onclick="window.print()" >Print</button>
       </div>
       <div class="page-content container">
           <div class="block">
               <div class="row">
                   <div class="col-12">
                       <div class="text-center text-150"> 
                       <i class="fa fa-book fa-2x text-success-m2 mr-1"></i> 
                       <span class="text-default-d3">Online Shop</span>
                       </div>
                   </div>
               </div>					
               <div class="table-container table is-bordered">
                   <table class="table" id="Table">
                   <thead>
                   <tr>
                     <th>To: </th>
                     <th>Date: </th>
                   </tr>
                   </thead>
                   <tbody>
                   <tr>
                     <td>'.fill::fillinvoice ($reference, 6).'</td>
                     <td>'.fill::fillinvoice ($reference, 4).'</td>
                   </tr>
                   </tbody>
                 </table>											
                   <div class="is-hoverable center">
                     <table class="table" id="Table">
                       <thead class="text-white bgc-default-tp1">
                       <tr>
                         <th>Product Code</th>
                         <th>Product Name</th>
                         <th>Quality</th>
                         <th>Unit Price</th>
                         <th>Amount</th>
                       </tr>
                       </thead>
                       <tbody>
                       '.fill::fillinvoice ($reference, 1).'
                       </tbody>
                     </table>
                   </div>
                   <div class="row mt-3">
                   <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0"> Extra note</div>
                       <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                           <div class="row my-2">
                               <div class="col-7 text-right"> SubTotal	</div>
                               <div class="col-5"> <span class="text-120 text-secondary-d1">'.fill::fillinvoice ($reference, 5)-$shipping.'$</span>	</div>
                           </div>
                           <div class="row my-2">
                               <div class="col-7 text-right">  Shipping</div>
                               <div class="col-5"> <span class="text-110 text-secondary-d1">'.fill::fillinvoice($reference, 2) .": ".$shipping.'$</span></div>
                           </div>
                           <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                               <div class="col-7 text-right"> Total Amount	</div>
                               <div class="col-5"> <span class="text-150 text-success-d3 opacity-2">'.fill::fillinvoice ($reference, 5).'$	</span>	</div>
                               <span class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">Status operation: '.fill::fillinvoice ($reference, 3).' </span><br>
                           </div>
                       </div>
                   </div>
               </div>			
           </div>	
       </div>				
       <!--Separator--> 
       <div class="container container-full">
           <div class="columns is-centered is-multiline">
               <div class="separator"></div>
           </div>
       </div> 
       <!--Authorship info--> 
           <div class="footer-bar-top">
               <div class="container">
                   <a class="footer-bar-top-links" href="#">2021 Online Shop</a>
               </div>
           </div>
       </footer>
       <!--Dinamic bar -->
   <script src="js/main.js"></script>';
            return $page1;
            break;
            case 2:
                $page2='<!--Upper section--><header>
                <nav class="navbar ">
                       <header class="nabvar-mobile is-size-5-mobile">
                       <form action="index.php" style="padding-top:50px">
                           <button class="delete is-large"></button>
                       </form>
                           <a class="navbar-mobile-link has-text-white" href="#" id="btn-mobile"><i></i></a>
                           <a class="navbar-mobile-link has-text-white" style="padding-top:50px">Invoice ID: '. shoppingcart::currentshipping(1).'</a>
                           <a class="navbar-mobile-link has-text-white" href="cart.php"><i></i></a>
                       </header>
                   </nav>
                   <nav class="navbar-top">
                       <ul class="navbar-top-ul">
                           <li class="navbar-top-item">
                                <form action="cart.php">
                               <button class="delete is-large"></button>
                               </form>
                           </li>
                       </ul>
                   </nav>
               <!--Banner-->
               <div class="banner-second">
                   <div class="banner-container ">
                       <div class="page-content container">
                           <div class="block">
                               <div class="row">
                                   <div class="col-12">
                                       <div class="text-center text-150" style=""> 
                                       <i class="fa fa-book fa-2x text-success-m2 mr-1"></i> 
                                       <span class="text-default-d3" style="color:#2F3A67">Invoice ID:'.shoppingcart::currentshipping(1).'</span>
                                       </div>
                                   </div>
                               </div>
                           </div>	
                       </div>
                   </div>
               </div> 
               <div class="page-content container">
                   <div class="block">
                       <div class="row">
                           <div class="col-12">
                               <div class="text-center text-150"> 
                               <i class="fa fa-book fa-2x text-success-m2 mr-1"></i> 
                               <span class="text-default-d3">Online Shop</span>
                               </div>
                           </div>
                       </div>					
                       <div class="table-container table is-bordered">
                           <table class="table" id="Table">
                           <thead>
                           <tr>
                             <th>To: </th>
                             <th>Date: </th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr>
                             <td>'.$_SESSION['name'].'</td>
                             <td>'.date("m/d/Y").'</td>
                           </tr>
                           </tbody>
                         </table>											
                           <div class="is-hoverable center">
                             <table class="table" id="Table">
                               <thead class="text-white bgc-default-tp1">
                               <tr>
                                 <th>Product Code</th>
                                 <th>Product Name</th>
                                 <th>Quality</th>
                                 <th>Unit Price</th>
                                 <th>Amount</th>
                               </tr>
                               </thead>
                               <tbody>
                               '.fill::fillcartinvoice().'
                               </tbody>
                             </table>
                           </div>
                           <div class="row mt-3">
                           <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0"> Extra note</div>
                               <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                   <div class="row my-2">
                                       <div class="col-7 text-right"> SubTotal	</div>
                                       <div class="col-5"> <span class="text-120 text-secondary-d1">'. round(shoppingcart::totalcart (),2).'$</span>	</div>
                                   </div>
                                   <div class="row my-2">
                                       <div class="col-7 text-right">  Shipping</div>
                                       <div class="col-5"> <span class="text-110 text-secondary-d1">'. shoppingcart::currentshipping(2) .": ".$shipping.'$</span></div>
                                   </div>
                                   <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                       <div class="col-7 text-right"> Total Amount	</div>
                                       <div class="col-5"> <span class="text-150 text-success-d3 opacity-2">'.round(shoppingcart::totalcart (),2)+$shipping.'$	</span>	</div>
                                       <span class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">Status operation: '. shoppingcart::currentshipping(3).' </span><br>
                                       <form action="#"  method="POST"><button class="btn btn-info btn-bold px-4 float-right mt-3 mt-lg-0" name="Pay">Pay</button></form>
                                   </div>
                               </div>
                           </div>
                       </div>			
                   </div>	
               </div>				
               <!--Separator--> 
               <div class="container container-full">
                   <div class="columns is-centered is-multiline">
                       <div class="separator"></div>
                   </div>
               </div> 
               <!--Authorship info--> 
                   <div class="footer-bar-top">
                       <div class="container">
                           <a class="footer-bar-top-links" href="#">2021 Online Shop</a>
                       </div>
                   </div>
               </footer>
               <!--Dinamic bar -->
             <script src="js/main.js"></script>';
            return $page2;
            break;
            case 3:
                $page3='<!--Upper section--><header>
                <nav class="navbar ">
                       <header class="nabvar-mobile is-size-5-mobile">
                       <form action="index.php" style="padding-top:50px">
                           <button class="delete is-large"></button>
                       </form>
                           <a class="navbar-mobile-link has-text-white" href="#" id="btn-mobile"><i></i></a>
                           <a class="navbar-mobile-link has-text-white" style="padding-top:50px">Select ID</a>
                           <a class="navbar-mobile-link has-text-white" href="../"><i></i></a>
                       </header>
                   </nav>
                   <nav class="navbar-top">
                       <ul class="navbar-top-ul">
                           <li class="navbar-top-item">
                                <form action="../">
                               <button class="delete is-large"></button>
                               </form>
                           </li>
                       </ul>
                   </nav>
               <!--Banner-->
               <div class="banner-second">
                   <div class="banner-container ">
                       <div class="page-content container">
                           <div class="block">
                               <div class="row">
                                   <div class="col-12">
                                       <div class="text-center text-150" style=""> 
                                       <i class="fa fa-book fa-2x text-success-m2 mr-1"></i> 
                                       <span class="text-default-d3" style="color:#2F3A67">Select ID</span>
                                       </div>
                                   </div>
                               </div>
                           </div>	
                       </div>
                   </div>
               </div> 
               <div class="page-content container">
                   <div class="block">
                       <div class="row">
                           <div class="col-12">
                               <div class="text-center text-150"> 
                               <i class="fa fa-book fa-2x text-success-m2 mr-1"></i> 
                               <span class="text-default-d3">Online Shop</span>
                               </div>
                           </div>
                       </div>					
                       <div class="table-container table is-bordered">
                           <table class="table" id="Table">
                           <thead>
                           <tr>
                             <th>User: </th>
                             <th>Date: </th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr>
                             <td>'.$_SESSION['name'].'</td>
                             <td>'.date("m/d/Y").'</td>
                           </tr>
                           </tbody>
                         </table>											
                           <div class="is-hoverable center">
                             <table class="table" id="Table">
                               <thead class="text-white bgc-default-tp1">
                               <tr>
                                 <th>Invoice</th>
                                 <th>Date</th>
                                 <th>User</th>
                                 <th>Total Price</th>
                                 <th>Status</th>
                               </tr>
                               </thead>
                               <tbody>
                               '.fill::filllistinvoice().'
                               </tbody>
                             </table>
                           </div>
                       </div>			
                   </div>	
               </div>				
               <!--Separator--> 
               <div class="container container-full">
                   <div class="columns is-centered is-multiline">
                       <div class="separator"></div>
                   </div>
               </div> 
               <!--Authorship info--> 
                   <div class="footer-bar-top">
                       <div class="container">
                           <a class="footer-bar-top-links" href="#">2021 Online Shop</a>
                       </div>
                   </div>
               </footer>
               <!--Dinamic bar -->
             <script src="js/main.js"></script>';
            return $page3;
            break;
            case 4:
            return $page4;
            break;
            case 5:
            return $page5;
            break;
        }
    } 
}
?>