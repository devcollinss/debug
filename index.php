<?php

include "../connection.php";
include "../auth.php";
// $_SESSION['msg'] = '';

function select_data($instruction) {
  $query = "SELECT $instruction";
  $result = $link->query($query);
  // Check for query errors
  if (!$result) {
    return "Failed to execute SELECT statement: " . mysqli_error($link);
  }

  // Fetch the results
  $results = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Close the connection
  mysqli_close($link);

  echo '<script>alert('.$result.')</script>';
}



?>
<!DOCTYPE html>
<html lang="en">
<style>
   .withdrawType input[type="radio"] {
  display: none;
}

</style>
<?php include "../layout/head.php"; ?>

<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
  <div class="nk-app-root">
    <div class="nk-main">
      <?php include "../layout/sidebar.php"; ?>
      <div class="nk-wrap">
        <?php include "../layout/header2.php"; ?>
        <div class="nk-content">
          <div class="container-fluid">
            <div class="nk-content-inner">
              <div class="nk-content-body">
                <div class="row g-gs">
                        <section class="price_plan_area section_padding_130_80" id="pricing">
                          <div class="container">
       
                            <div class="row justify-content-center">
                            <div class="col-12 col-sm-8 col-lg-6">
                                <!-- Section Heading-->
                                <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                <h3>Withdraw</h3>
                                <div class="line"></div>
                                </div>
                            </div>
                            </div>
                            <div class="row justify-content-center">
                          
                          <div class="col-12 col-sm-8 col-md-6 col-lg-6">
                            <div class="single_price_plan wow fadeInUp" id="form" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                <div class="error"></div>
                                <div class="success"><?php if(isset($_SESSION['msg'])) { echo $_SESSION['msg']; }?></div>
                                <div class="title">
                                    <label style="text-transform: capitalize" class="form-label">Enter Amount</label>
                                    <input type="text" class="col-12 form-control amount" placeholder="Enter Amount">
                                </div>
                                <div class="description">
                                    <h3>Choose Withdrawal Method from the list below</h3>
                                    <div class="row gap-3">
                                    <div class="btn-group withdrawType" role="group" aria-label="Radio button example">
                                        <!-- <div> -->
                                          
                                            <label class="btn btn-danger">
                                                <input type="radio" name="withMtd" value="1" id="1" autocomplete="off"> 
                                                <span>Crypto</span> 
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="withMtd" value="2" id="2" autocomplete="off">
                                                <span>Bank Account</span> 
                                            </label>
                                        <!-- </div> -->
                                    </div>
                                    </div>
                                </div>
                                <div class="price">
                                    <p>Selected Method: <b id="withMtd" class="text-danger">nonwe</b></p>
                                </div>
                                <div class="button mt-5">
                                    <a class="btn btn-success btn-2" id="withdraw">Proceed to payment</a>
                                </div>
                            </div>
                        </div>
                        
                        </div>
                        </div>
                    </section>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Button trigger modal -->
        <?php include "../layout/footer.php" ?>
      </div>
    </div>
  </div>
</body>
<script src="../assets/js/bundle.js"></script>
<script src="../assets/js/scripts.js"></script>
<script src="../assets/js/functions.js"></script>
<script>
    
document.querySelectorAll('.withdrawType input[type="radio"]').forEach(function(radioButton) {
  radioButton.addEventListener('change', function() {
    document.querySelectorAll('.withdrawType input[type="radio"]').forEach(function(radioButton) {
      radioButton.parentElement.classList.add('btn-danger');
      radioButton.parentElement.classList.remove('btn-warning');
    });
    if (this.checked) {
      this.parentElement.classList.add('btn-warning');
      this.parentElement.classList.remove('btn-danger');
      
      async function sendAjaxRequest(instruction) {
  try {
    // Send the request and get the response
    const response = await fetch('process.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `instruction=${instruction}`
    });
    // Check the status of the response
    if (response.ok) {
      // The request was successful.
      // Get the data returned by the server as a JSON object
      const data = await response.json();
      // Process the data
      console.log(data);
    } else {
      // The request failed.
      console.log(`Error: ${response.status}`);
    }
  } catch (error) {
    // There was an error sending the request
    console.log(error);
  }
}

// Call the function with the instruction parameter
sendAjaxRequest('* FROM wallets');


    }
  });
});
document.querySelectorAll('.withdrawType label').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelector('#withMtd').textContent = btn.querySelector('span').textContent;
    })
});
document.querySelector('#form').addEventListener('click', () => {
  const textInput = document.querySelector('#form input[type=text]');
  const radioButton = document.querySelector('#form input[type=radio]');

  document.querySelector('#withdraw').addEventListener('click', () => {
  if (textInput.value === '' && !radioButton.checked) {
    let html = `<div class="alert alert-danger" role="alert">
            No field should be empty!
        </div>`;
        document.querySelector('.error').innerHTML = html;
  } else {
    var event = new MouseEvent("click", {
        "view": window,
        "bubbles": true,
        "cancelable": false
    });
    let modal = document.createElement('button');
    modal.setAttribute('data-bs-toggle', 'modal')
    modal.setAttribute('data-bs-target', '#addPlanModal')
    document.querySelector('body').append(modal)
    //This is where the auto triger is called
    modal.dispatchEvent(event);

  }
});
});


</script>

<div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="addPlanModalLabel">You selected Crypto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="msg mb3"></div>
            <form method="post" action="process.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <h3>You are about to make a Withdrawal of <span class="amountInputted text-danger"></span></h3>
                    <p class="text-danger">Select your preferred wallet</p>
                    <label class="mx-2">
                        <input type="radio" name="withMtd" id="wallet" autocomplete="off"> 
                        <span>Eth</span> 
                    </label>
                    <label class="mx-2">
                        <input type="radio" name="withMtd" id="account_nos" autocomplete="off"> 
                        <span>BTC</span> 
                    </label>
                    <label class="mx-2">
                        <input type="radio" name="withMtd" id="1" autocomplete="off"> 
                        <span>USDT</span> 
                    </label>
                        <input type="hidden" name="depAmount" class="depAmount">
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="button" class="btn btn-success" onClick="$.confirm({
                                                                            title: 'Confirm withdrawal Details!',
                                                                            content: '<b>Name: </b>Simple confirm!<br /> <b>Number:s</b>',
                                                                            buttons: {
                                                                                confirm: function () {
                                                                                    $.alert('Confirmed!');
                                                                                },
                                                                                cancel: function () {
                                                                                    $.alert('Canceled!');
                                                                                },
                                                                                
                                                                            }
                                                                          });">Confirm Details</button>
                </div>
        </form>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.2.min.js"
  integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"
  integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</html>
