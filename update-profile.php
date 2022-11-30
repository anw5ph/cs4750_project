<?php
require('connect-db.php');
require("functions.php");

session_start();
if (isset($_COOKIE['user']))
{
$curr_user = $_SESSION['curr_user'];
$userInfo = getUser($curr_user);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Update') {
        updateUser($curr_user, $_POST['firstName'], $_POST['middleName'], $_POST['lastName'], $_POST['email'], $_POST['location']);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="your name">
        <meta name="description" content="include some description about your page">  
            
        <title>Update Profile</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
        <link rel="stylesheet" type="text/css" href="update-profile.css">
        
    </head>

    <body>
    <header>  
          <nav class="navbar navbar-expand-md navbar-dark navbar-custom" style="--bs-bg-opacity: 1;
    background-color: #232D4B;">
            <div class="container-fluid">            
              <a class="navbar-brand" href="#">Welcome <?php echo $userInfo['firstName']; ?>!</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="my-account.php">My Account</a>
                  </li> 
                </ul>
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="addtransaction.php">Add Transaction</a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link" id="btn-nav" data-bs-toggle="modal" data-bs-target="#exampleModal">Logout</a>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </header>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center">
                <div class="mt-4 text-danger" style="height: 50px;">Are you sure you want to logout?</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <form action="home.php" method="post">
                    <input type = "submit" value="Logout" class = "btn btn-outline-danger btn-sm" name = "logOut"
                              title="Logout(Placeholder)" />
                </form>
              </div>
            </div>
          </div>
        </div>
    <div class="container">
        <div class="row align-items-center justify-content-center" style="min-height: 100vh">
            <div class="col-md-4">

                <form action="update-profile.php" method="post">

                    <h2 style="text-align: center; color: gray;">Update Profile</h2>
                    <br>

                    <?php if (isset($_GET['error'])) { ?>

                        <p class="error"><?php echo $_GET['error']; ?></p>

                    <?php } ?>
                    <!-- First name input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="firstName" id="firstNameInput" class="form-control" value="<?php if ($userInfo['firstName'] != null) echo $userInfo['firstName']?>"/>
                    </div>

                    <!-- Middle name input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="middleName" id="middleNameInput" class="form-control" value="<?php if ($userInfo['middleName'] != null) echo $userInfo['middleName']?>"/>
                    </div>

                    <!-- Last name input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="lastName" id="lastInput" class="form-control" value="<?php if ($userInfo['lastName'] != null) echo $userInfo['lastName']?>"/>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" name="email" id="emailInput" class="form-control" value="<?php if ($userInfo['email'] != null) echo $userInfo['email']?>"/>
                    </div>

                    <!-- Location input -->
                    <div class="form-outline mb-4">
                        <select name='location'>
                            <option name="Afghanistan">Afghanistan</option>
                            <option name="Albania">Albania</option>
                            <option name="Algeria">Algeria</option>
                            <option name="American Samoa">American Samoa</option>
                            <option name="Andorra">Andorra</option>
                            <option name="Angola">Angola</option>
                            <option name="Anguilla">Anguilla</option>
                            <option name="Antartica">Antarctica</option>
                            <option name="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option name="Argentina">Argentina</option>
                            <option name="Armenia">Armenia</option>
                            <option name="Aruba">Aruba</option>
                            <option name="Australia">Australia</option>
                            <option name="Austria">Austria</option>
                            <option name="Azerbaijan">Azerbaijan</option>
                            <option name="Bahamas">Bahamas</option>
                            <option name="Bahrain">Bahrain</option>
                            <option name="Bangladesh">Bangladesh</option>
                            <option name="Barbados">Barbados</option>
                            <option name="Belarus">Belarus</option>
                            <option name="Belgium">Belgium</option>
                            <option name="Belize">Belize</option>
                            <option name="Benin">Benin</option>
                            <option name="Bermuda">Bermuda</option>
                            <option name="Bhutan">Bhutan</option>
                            <option name="Bolivia">Bolivia</option>
                            <option name="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                            <option name="Botswana">Botswana</option>
                            <option name="Bouvet Island">Bouvet Island</option>
                            <option name="Brazil">Brazil</option>
                            <option name="British Indian Ocean Territory">British Indian Ocean Territory</option>
                            <option name="Brunei Darussalam">Brunei Darussalam</option>
                            <option name="Bulgaria">Bulgaria</option>
                            <option name="Burkina Faso">Burkina Faso</option>
                            <option name="Burundi">Burundi</option>
                            <option name="Cambodia">Cambodia</option>
                            <option name="Cameroon">Cameroon</option>
                            <option name="Canada">Canada</option>
                            <option name="Cape Verde">Cape Verde</option>
                            <option name="Cayman Islands">Cayman Islands</option>
                            <option name="Central African Republic">Central African Republic</option>
                            <option name="Chad">Chad</option>
                            <option name="Chile">Chile</option>
                            <option name="China">China</option>
                            <option name="Christmas Island">Christmas Island</option>
                            <option name="Cocos Islands">Cocos (Keeling) Islands</option>
                            <option name="Colombia">Colombia</option>
                            <option name="Comoros">Comoros</option>
                            <option name="Congo">Congo</option>
                            <option name="Congo">Congo, the Democratic Republic of the</option>
                            <option name="Cook Islands">Cook Islands</option>
                            <option name="Costa Rica">Costa Rica</option>
                            <option name="Cota D'Ivoire">Cote d'Ivoire</option>
                            <option name="Croatia">Croatia (Hrvatska)</option>
                            <option name="Cuba">Cuba</option>
                            <option name="Cyprus">Cyprus</option>
                            <option name="Czech Republic">Czech Republic</option>
                            <option name="Denmark">Denmark</option>
                            <option name="Djibouti">Djibouti</option>
                            <option name="Dominica">Dominica</option>
                            <option name="Dominican Republic">Dominican Republic</option>
                            <option name="East Timor">East Timor</option>
                            <option name="Ecuador">Ecuador</option>
                            <option name="Egypt">Egypt</option>
                            <option name="El Salvador">El Salvador</option>
                            <option name="Equatorial Guinea">Equatorial Guinea</option>
                            <option name="Eritrea">Eritrea</option>
                            <option name="Estonia">Estonia</option>
                            <option name="Ethiopia">Ethiopia</option>
                            <option name="Falkland Islands">Falkland Islands (Malvinas)</option>
                            <option name="Faroe Islands">Faroe Islands</option>
                            <option name="Fiji">Fiji</option>
                            <option name="Finland">Finland</option>
                            <option name="France">France</option>
                            <option name="France Metropolitan">France, Metropolitan</option>
                            <option name="French Guiana">French Guiana</option>
                            <option name="French Polynesia">French Polynesia</option>
                            <option name="French Southern Territories">French Southern Territories</option>
                            <option name="Gabon">Gabon</option>
                            <option name="Gambia">Gambia</option>
                            <option name="Georgia">Georgia</option>
                            <option name="Germany">Germany</option>
                            <option name="Ghana">Ghana</option>
                            <option name="Gibraltar">Gibraltar</option>
                            <option name="Greece">Greece</option>
                            <option name="Greenland">Greenland</option>
                            <option name="Grenada">Grenada</option>
                            <option name="Guadeloupe">Guadeloupe</option>
                            <option name="Guam">Guam</option>
                            <option name="Guatemala">Guatemala</option>
                            <option name="Guinea">Guinea</option>
                            <option name="Guinea-Bissau">Guinea-Bissau</option>
                            <option name="Guyana">Guyana</option>
                            <option name="Haiti">Haiti</option>
                            <option name="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                            <option name="Holy See">Holy See (Vatican City State)</option>
                            <option name="Honduras">Honduras</option>
                            <option name="Hong Kong">Hong Kong</option>
                            <option name="Hungary">Hungary</option>
                            <option name="Iceland">Iceland</option>
                            <option name="India">India</option>
                            <option name="Indonesia">Indonesia</option>
                            <option name="Iran">Iran (Islamic Republic of)</option>
                            <option name="Iraq">Iraq</option>
                            <option name="Ireland">Ireland</option>
                            <option name="Israel">Israel</option>
                            <option name="Italy">Italy</option>
                            <option name="Jamaica">Jamaica</option>
                            <option name="Japan">Japan</option>
                            <option name="Jordan">Jordan</option>
                            <option name="Kazakhstan">Kazakhstan</option>
                            <option name="Kenya">Kenya</option>
                            <option name="Kiribati">Kiribati</option>
                            <option name="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
                            <option name="Korea">Korea, Republic of</option>
                            <option name="Kuwait">Kuwait</option>
                            <option name="Kyrgyzstan">Kyrgyzstan</option>
                            <option name="Lao">Lao People's Democratic Republic</option>
                            <option name="Latvia">Latvia</option>
                            <option name="Lebanon">Lebanon</option>
                            <option name="Lesotho">Lesotho</option>
                            <option name="Liberia">Liberia</option>
                            <option name="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                            <option name="Liechtenstein">Liechtenstein</option>
                            <option name="Lithuania">Lithuania</option>
                            <option name="Luxembourg">Luxembourg</option>
                            <option name="Macau">Macau</option>
                            <option name="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                            <option name="Madagascar">Madagascar</option>
                            <option name="Malawi">Malawi</option>
                            <option name="Malaysia">Malaysia</option>
                            <option name="Maldives">Maldives</option>
                            <option name="Mali">Mali</option>
                            <option name="Malta">Malta</option>
                            <option name="Marshall Islands">Marshall Islands</option>
                            <option name="Martinique">Martinique</option>
                            <option name="Mauritania">Mauritania</option>
                            <option name="Mauritius">Mauritius</option>
                            <option name="Mayotte">Mayotte</option>
                            <option name="Mexico">Mexico</option>
                            <option name="Micronesia">Micronesia, Federated States of</option>
                            <option name="Moldova">Moldova, Republic of</option>
                            <option name="Monaco">Monaco</option>
                            <option name="Mongolia">Mongolia</option>
                            <option name="Montserrat">Montserrat</option>
                            <option name="Morocco">Morocco</option>
                            <option name="Mozambique">Mozambique</option>
                            <option name="Myanmar">Myanmar</option>
                            <option name="Namibia">Namibia</option>
                            <option name="Nauru">Nauru</option>
                            <option name="Nepal">Nepal</option>
                            <option name="Netherlands">Netherlands</option>
                            <option name="Netherlands Antilles">Netherlands Antilles</option>
                            <option name="New Caledonia">New Caledonia</option>
                            <option name="New Zealand">New Zealand</option>
                            <option name="Nicaragua">Nicaragua</option>
                            <option name="Niger">Niger</option>
                            <option name="Nigeria">Nigeria</option>
                            <option name="Niue">Niue</option>
                            <option name="Norfolk Island">Norfolk Island</option>
                            <option name="Northern Mariana Islands">Northern Mariana Islands</option>
                            <option name="Norway">Norway</option>
                            <option name="Oman">Oman</option>
                            <option name="Pakistan">Pakistan</option>
                            <option name="Palau">Palau</option>
                            <option name="Panama">Panama</option>
                            <option name="Papua New Guinea">Papua New Guinea</option>
                            <option name="Paraguay">Paraguay</option>
                            <option name="Peru">Peru</option>
                            <option name="Philippines">Philippines</option>
                            <option name="Pitcairn">Pitcairn</option>
                            <option name="Poland">Poland</option>
                            <option name="Portugal">Portugal</option>
                            <option name="Puerto Rico">Puerto Rico</option>
                            <option name="Qatar">Qatar</option>
                            <option name="Reunion">Reunion</option>
                            <option name="Romania">Romania</option>
                            <option name="Russia">Russian Federation</option>
                            <option name="Rwanda">Rwanda</option>
                            <option name="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                            <option name="Saint LUCIA">Saint LUCIA</option>
                            <option name="Saint Vincent">Saint Vincent and the Grenadines</option>
                            <option name="Samoa">Samoa</option>
                            <option name="San Marino">San Marino</option>
                            <option name="Sao Tome and Principe">Sao Tome and Principe</option> 
                            <option name="Saudi Arabia">Saudi Arabia</option>
                            <option name="Senegal">Senegal</option>
                            <option name="Seychelles">Seychelles</option>
                            <option name="Sierra">Sierra Leone</option>
                            <option name="Singapore">Singapore</option>
                            <option name="Slovakia">Slovakia (Slovak Republic)</option>
                            <option name="Slovenia">Slovenia</option>
                            <option name="Solomon Islands">Solomon Islands</option>
                            <option name="Somalia">Somalia</option>
                            <option name="South Africa">South Africa</option>
                            <option name="South Georgia">South Georgia and the South Sandwich Islands</option>
                            <option name="Span">Spain</option>
                            <option name="SriLanka">Sri Lanka</option>
                            <option name="St. Helena">St. Helena</option>
                            <option name="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                            <option name="Sudan">Sudan</option>
                            <option name="Suriname">Suriname</option>
                            <option name="Svalbard">Svalbard and Jan Mayen Islands</option>
                            <option name="Swaziland">Swaziland</option>
                            <option name="Sweden">Sweden</option>
                            <option name="Switzerland">Switzerland</option>
                            <option name="Syria">Syrian Arab Republic</option>
                            <option name="Taiwan">Taiwan, Province of China</option>
                            <option name="Tajikistan">Tajikistan</option>
                            <option name="Tanzania">Tanzania, United Republic of</option>
                            <option name="Thailand">Thailand</option>
                            <option name="Togo">Togo</option>
                            <option name="Tokelau">Tokelau</option>
                            <option name="Tonga">Tonga</option>
                            <option name="Trinidad and Tobago">Trinidad and Tobago</option>
                            <option name="Tunisia">Tunisia</option>
                            <option name="Turkey">Turkey</option>
                            <option name="Turkmenistan">Turkmenistan</option>
                            <option name="Turks and Caicos">Turks and Caicos Islands</option>
                            <option name="Tuvalu">Tuvalu</option>
                            <option name="Uganda">Uganda</option>
                            <option name="Ukraine">Ukraine</option>
                            <option name="United Arab Emirates">United Arab Emirates</option>
                            <option name="United Kingdom">United Kingdom</option>
                            <option name="United States" selected>United States</option>
                            <option name="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                            <option name="Uruguay">Uruguay</option>
                            <option name="Uzbekistan">Uzbekistan</option>
                            <option name="Vanuatu">Vanuatu</option>
                            <option name="Venezuela">Venezuela</option>
                            <option name="Vietnam">Viet Nam</option>
                            <option name="Virgin Islands (British)">Virgin Islands (British)</option>
                            <option name="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                            <option name="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                            <option name="Western Sahara">Western Sahara</option>
                            <option name="Yemen">Yemen</option>
                            <option name="Serbia">Serbia</option>
                            <option name="Zambia">Zambia</option>
                            <option name="Zimbabwe">Zimbabwe</option>
                        </select>
                    </div>
                    <!-- Submit button -->
                        <button type="submit" value="Update" name="btnAction" class="btn btn-primary btn-block mb-4" style="background-color: #F84C1E; border-color: #F84C1E; width: 100%; box-shadow: 0 4px 9px -4px #F84C1E; hover-bg: #F84C1E; active-bg: #F84C1E;" >Update</button>

                </form>
            </div>
        </div>
    </div>
           
        </div>
    </div>

<div class="container-fluid" id="footer-container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-4-md d-flex align-items-center" style="padding-left: 6em;">
      <span class="mb-3 mb-md-8 text-muted">© 2022 Alexander Williams, Bryant Chow, Connor McCaffrey, and George Sun</span>
    </div>
    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex" style="padding-right: 6em;">
      <li class="ms-3">
        <a class="text-muted" href="https://github.com/anw5ph/cs4750_project/">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
          </svg>
        </a>
        
      </li>
    </ul>
  </footer>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <?php
} else {
    header('Location: login.php');
}
?>    
</body>
</html>