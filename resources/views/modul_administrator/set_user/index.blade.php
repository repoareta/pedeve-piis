@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
            Set User
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <div class="">
                    <a href="#">
                        <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                    </a>
                    <span class="text-warning pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-edit" id="editRow"></i>
                    </span>

                    <span class="text-danger pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-times-circle" id="deleteRow"></i>
                    </span>
                    <span class="text-info pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
                        <i class="fas fa-print" id="exportRow"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form class="form" id="kt_form">
            <div class="row">
                <div class="col-xl-2"></div>
                <div class="col-xl-8">
                    <div class="my-5">
                        <h3 class="text-dark font-weight-bold mb-10">Customer Info:</h3>
                        <div class="form-group row">
                            <label class="col-3">First Name</label>
                            <div class="col-9">
                                <input class="form-control" type="text" value="Nick" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Last Name</label>
                            <div class="col-9">
                                <input class="form-control" type="text" value="Watson" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Company Name</label>
                            <div class="col-9">
                                <input class="form-control" type="text" value="Loop Inc." />
                                <span class="form-text text-muted">If you want your invoices addressed to a company. Leave blank to use your full name.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Contact Phone</label>
                            <div class="col-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-phone"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" value="+45678967456" placeholder="Phone" />
                                </div>
                                <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Email Address</label>
                            <div class="col-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-at"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" value="nick.watson@loop.com" placeholder="Email" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Company Site</label>
                            <div class="col-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Username" value="loop" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-10"></div>
                    <div class="my-5">
                        <h3 class="text-dark font-weight-bold mb-10">Address Details:</h3>
                        <div class="form-group row">
                            <label class="col-3">Country</label>
                            <div class="col-9">
                                <select class="form-control">
                                    <option value="AF">Afghanistan</option>
                                    <option value="AX">Åland Islands</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaijan</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BY">Belarus</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia, Plurinational State of</option>
                                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="BA">Bosnia and Herzegovina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BV">Bouvet Island</option>
                                    <option value="BR">Brazil</option>
                                    <option value="IO">British Indian Ocean Territory</option>
                                    <option value="BN">Brunei Darussalam</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="KH">Cambodia</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CA">Canada</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="KY">Cayman Islands</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="TD">Chad</option>
                                    <option value="CL">Chile</option>
                                    <option value="CN">China</option>
                                    <option value="CX">Christmas Island</option>
                                    <option value="CC">Cocos (Keeling) Islands</option>
                                    <option value="CO">Colombia</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo</option>
                                    <option value="CD">Congo, the Democratic Republic of the</option>
                                    <option value="CK">Cook Islands</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="CI">Côte d'Ivoire</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CW">Curaçao</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DM">Dominica</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="FK">Falkland Islands (Malvinas)</option>
                                    <option value="FO">Faroe Islands</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="GF">French Guiana</option>
                                    <option value="PF">French Polynesia</option>
                                    <option value="TF">French Southern Territories</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="DE">Germany</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GR">Greece</option>
                                    <option value="GL">Greenland</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GP">Guadeloupe</option>
                                    <option value="GU">Guam</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GG">Guernsey</option>
                                    <option value="GN">Guinea</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GY">Guyana</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HM">Heard Island and McDonald Islands</option>
                                    <option value="VA">Holy See (Vatican City State)</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IS">Iceland</option>
                                    <option value="IN">India</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="IR">Iran, Islamic Republic of</option>
                                    <option value="IQ">Iraq</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IM">Isle of Man</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JE">Jersey</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KI">Kiribati</option>
                                    <option value="KP">Korea, Democratic People's Republic of</option>
                                    <option value="KR">Korea, Republic of</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="LA">Lao People's Democratic Republic</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LS">Lesotho</option>
                                    <option value="LR">Liberia</option>
                                    <option value="LY">Libya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MO">Macao</option>
                                    <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>
                                    <option value="MX">Mexico</option>
                                    <option value="FM">Micronesia, Federated States of</option>
                                    <option value="MD">Moldova, Republic of</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="ME">Montenegro</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="NC">New Caledonia</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="MP">Northern Mariana Islands</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PW">Palau</option>
                                    <option value="PS">Palestinian Territory, Occupied</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PN">Pitcairn</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RE">Réunion</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="BL">Saint Barthélemy</option>
                                    <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                    <option value="KN">Saint Kitts and Nevis</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="MF">Saint Martin (French part)</option>
                                    <option value="PM">Saint Pierre and Miquelon</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="WS">Samoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="ST">Sao Tome and Principe</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="RS">Serbia</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SX">Sint Maarten (Dutch part)</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                                    <option value="SS">South Sudan</option>
                                    <option value="ES">Spain</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syrian Arab Republic</option>
                                    <option value="TW">Taiwan, Province of China</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania, United Republic of</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TL">Timor-Leste</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="US" selected="selected">United States</option>
                                    <option value="UM">United States Minor Outlying Islands</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VE">Venezuela, Bolivarian Republic of</option>
                                    <option value="VN">Viet Nam</option>
                                    <option value="VG">Virgin Islands, British</option>
                                    <option value="VI">Virgin Islands, U.S.</option>
                                    <option value="WF">Wallis and Futuna</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="YE">Yemen</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Address Line 1</label>
                            <div class="col-9">
                                <input class="form-control" type="text" value="District 6 1352 W. Olive Ave" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Address Line 2</label>
                            <div class="col-9">
                                <input class="form-control" type="text" value="Fresno 559-488-4020" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">City</label>
                            <div class="col-9">
                                <input class="form-control" type="text" value="Polo Alto" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">State / Province / Region</label>
                            <div class="col-9">
                                <input class="form-control" type="text" value="Los Angeles" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Zip / Postal Code</label>
                            <div class="col-9">
                                <input class="form-control" type="text" value="780456" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3"></label>
                            <div class="col-9">
                                <div class="checkbox-inline">
                                    <label class="checkbox">
                                    <input type="checkbox" />
                                    <span></span>Use as shipping address</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-10"></div>
                    <div class="my-5">
                        <h3 class="text-dark font-weight-bold mb-10">Account:</h3>
                        <div class="form-group row">
                            <label class="col-3">Username</label>
                            <div class="col-9">
                                <div class="spinner spinner-sm spinner-success spinner-right spinner-input">
                                    <input class="form-control" type="text" value="nick84" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Email Address</label>
                            <div class="col-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-at"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" value="nick.watson@loop.com" placeholder="Email" />
                                </div>
                                <span class="form-text text-muted">Email will not be publicly displayed.
                                <a href="#">Learn more</a>.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Language</label>
                            <div class="col-9">
                                <select class="form-control">
                                    <option>Select Language...</option>
                                    <option value="id">Bahasa Indonesia - Indonesian</option>
                                    <option value="msa">Bahasa Melayu - Malay</option>
                                    <option value="ca">Català - Catalan</option>
                                    <option value="cs">Čeština - Czech</option>
                                    <option value="da">Dansk - Danish</option>
                                    <option value="de">Deutsch - German</option>
                                    <option value="en" selected="selected">English</option>
                                    <option value="en-gb">English UK - British English</option>
                                    <option value="es">Español - Spanish</option>
                                    <option value="eu">Euskara - Basque (beta)</option>
                                    <option value="fil">Filipino</option>
                                    <option value="fr">Français - French</option>
                                    <option value="ga">Gaeilge - Irish (beta)</option>
                                    <option value="gl">Galego - Galician (beta)</option>
                                    <option value="hr">Hrvatski - Croatian</option>
                                    <option value="it">Italiano - Italian</option>
                                    <option value="hu">Magyar - Hungarian</option>
                                    <option value="nl">Nederlands - Dutch</option>
                                    <option value="no">Norsk - Norwegian</option>
                                    <option value="pl">Polski - Polish</option>
                                    <option value="pt">Português - Portuguese</option>
                                    <option value="ro">Română - Romanian</option>
                                    <option value="sk">Slovenčina - Slovak</option>
                                    <option value="fi">Suomi - Finnish</option>
                                    <option value="sv">Svenska - Swedish</option>
                                    <option value="vi">Tiếng Việt - Vietnamese</option>
                                    <option value="tr">Türkçe - Turkish</option>
                                    <option value="el">Ελληνικά - Greek</option>
                                    <option value="bg">Български език - Bulgarian</option>
                                    <option value="ru">Русский - Russian</option>
                                    <option value="sr">Српски - Serbian</option>
                                    <option value="uk">Українська мова - Ukrainian</option>
                                    <option value="he">עִבְרִית - Hebrew</option>
                                    <option value="ur">اردو - Urdu (beta)</option>
                                    <option value="ar">العربية - Arabic</option>
                                    <option value="fa">فارسی - Persian</option>
                                    <option value="mr">मराठी - Marathi</option>
                                    <option value="hi">हिन्दी - Hindi</option>
                                    <option value="bn">বাংলা - Bangla</option>
                                    <option value="gu">ગુજરાતી - Gujarati</option>
                                    <option value="ta">தமிழ் - Tamil</option>
                                    <option value="kn">ಕನ್ನಡ - Kannada</option>
                                    <option value="th">ภาษาไทย - Thai</option>
                                    <option value="ko">한국어 - Korean</option>
                                    <option value="ja">日本語 - Japanese</option>
                                    <option value="zh-cn">简体中文 - Simplified Chinese</option>
                                    <option value="zh-tw">繁體中文 - Traditional Chinese</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Time Zone</label>
                            <div class="col-9">
                                <select class="form-control">
                                    <option data-offset="-39600" value="International Date Line West">(GMT-11:00) International Date Line West</option>
                                    <option data-offset="-39600" value="Midway Island">(GMT-11:00) Midway Island</option>
                                    <option data-offset="-39600" value="Samoa">(GMT-11:00) Samoa</option>
                                    <option data-offset="-36000" value="Hawaii">(GMT-10:00) Hawaii</option>
                                    <option data-offset="-28800" value="Alaska">(GMT-08:00) Alaska</option>
                                    <option data-offset="-25200" value="Pacific Time (US &amp; Canada)">(GMT-07:00) Pacific Time (US &amp; Canada)</option>
                                    <option data-offset="-25200" value="Tijuana">(GMT-07:00) Tijuana</option>
                                    <option data-offset="-25200" value="Arizona">(GMT-07:00) Arizona</option>
                                    <option data-offset="-21600" value="Mountain Time (US &amp; Canada)">(GMT-06:00) Mountain Time (US &amp; Canada)</option>
                                    <option data-offset="-21600" value="Chihuahua">(GMT-06:00) Chihuahua</option>
                                    <option data-offset="-21600" value="Mazatlan">(GMT-06:00) Mazatlan</option>
                                    <option data-offset="-21600" value="Saskatchewan">(GMT-06:00) Saskatchewan</option>
                                    <option data-offset="-21600" value="Central America">(GMT-06:00) Central America</option>
                                    <option data-offset="-18000" value="Central Time (US &amp; Canada)">(GMT-05:00) Central Time (US &amp; Canada)</option>
                                    <option data-offset="-18000" value="Guadalajara">(GMT-05:00) Guadalajara</option>
                                    <option data-offset="-18000" value="Mexico City">(GMT-05:00) Mexico City</option>
                                    <option data-offset="-18000" value="Monterrey">(GMT-05:00) Monterrey</option>
                                    <option data-offset="-18000" value="Bogota">(GMT-05:00) Bogota</option>
                                    <option data-offset="-18000" value="Lima">(GMT-05:00) Lima</option>
                                    <option data-offset="-18000" value="Quito">(GMT-05:00) Quito</option>
                                    <option data-offset="-14400" value="Eastern Time (US &amp; Canada)">(GMT-04:00) Eastern Time (US &amp; Canada)</option>
                                    <option data-offset="-14400" value="Indiana (East)">(GMT-04:00) Indiana (East)</option>
                                    <option data-offset="-14400" value="Caracas">(GMT-04:00) Caracas</option>
                                    <option data-offset="-14400" value="La Paz">(GMT-04:00) La Paz</option>
                                    <option data-offset="-14400" value="Georgetown">(GMT-04:00) Georgetown</option>
                                    <option data-offset="-10800" value="Atlantic Time (Canada)">(GMT-03:00) Atlantic Time (Canada)</option>
                                    <option data-offset="-10800" value="Santiago">(GMT-03:00) Santiago</option>
                                    <option data-offset="-10800" value="Brasilia">(GMT-03:00) Brasilia</option>
                                    <option data-offset="-10800" value="Buenos Aires">(GMT-03:00) Buenos Aires</option>
                                    <option data-offset="-9000" value="Newfoundland">(GMT-02:30) Newfoundland</option>
                                    <option data-offset="-7200" value="Greenland">(GMT-02:00) Greenland</option>
                                    <option data-offset="-7200" value="Mid-Atlantic">(GMT-02:00) Mid-Atlantic</option>
                                    <option data-offset="-3600" value="Cape Verde Is.">(GMT-01:00) Cape Verde Is.</option>
                                    <option data-offset="0" value="Azores">(GMT) Azores</option>
                                    <option data-offset="0" value="Monrovia">(GMT) Monrovia</option>
                                    <option data-offset="0" value="UTC">(GMT) UTC</option>
                                    <option data-offset="3600" value="Dublin">(GMT+01:00) Dublin</option>
                                    <option data-offset="3600" value="Edinburgh">(GMT+01:00) Edinburgh</option>
                                    <option data-offset="3600" value="Lisbon">(GMT+01:00) Lisbon</option>
                                    <option data-offset="3600" value="London">(GMT+01:00) London</option>
                                    <option data-offset="3600" value="Casablanca">(GMT+01:00) Casablanca</option>
                                    <option data-offset="3600" value="West Central Africa">(GMT+01:00) West Central Africa</option>
                                    <option data-offset="7200" value="Belgrade">(GMT+02:00) Belgrade</option>
                                    <option data-offset="7200" value="Bratislava">(GMT+02:00) Bratislava</option>
                                    <option data-offset="7200" value="Budapest">(GMT+02:00) Budapest</option>
                                    <option data-offset="7200" value="Ljubljana">(GMT+02:00) Ljubljana</option>
                                    <option data-offset="7200" value="Prague">(GMT+02:00) Prague</option>
                                    <option data-offset="7200" value="Sarajevo">(GMT+02:00) Sarajevo</option>
                                    <option data-offset="7200" value="Skopje">(GMT+02:00) Skopje</option>
                                    <option data-offset="7200" value="Warsaw">(GMT+02:00) Warsaw</option>
                                    <option data-offset="7200" value="Zagreb">(GMT+02:00) Zagreb</option>
                                    <option data-offset="7200" value="Brussels">(GMT+02:00) Brussels</option>
                                    <option data-offset="7200" value="Copenhagen">(GMT+02:00) Copenhagen</option>
                                    <option data-offset="7200" value="Madrid">(GMT+02:00) Madrid</option>
                                    <option data-offset="7200" value="Paris">(GMT+02:00) Paris</option>
                                    <option data-offset="7200" value="Amsterdam">(GMT+02:00) Amsterdam</option>
                                    <option data-offset="7200" value="Berlin">(GMT+02:00) Berlin</option>
                                    <option data-offset="7200" value="Bern">(GMT+02:00) Bern</option>
                                    <option data-offset="7200" value="Rome">(GMT+02:00) Rome</option>
                                    <option data-offset="7200" value="Stockholm">(GMT+02:00) Stockholm</option>
                                    <option data-offset="7200" value="Vienna">(GMT+02:00) Vienna</option>
                                    <option data-offset="7200" value="Cairo">(GMT+02:00) Cairo</option>
                                    <option data-offset="7200" value="Harare">(GMT+02:00) Harare</option>
                                    <option data-offset="7200" value="Pretoria">(GMT+02:00) Pretoria</option>
                                    <option data-offset="10800" value="Bucharest">(GMT+03:00) Bucharest</option>
                                    <option data-offset="10800" value="Helsinki">(GMT+03:00) Helsinki</option>
                                    <option data-offset="10800" value="Kiev">(GMT+03:00) Kiev</option>
                                    <option data-offset="10800" value="Kyiv">(GMT+03:00) Kyiv</option>
                                    <option data-offset="10800" value="Riga">(GMT+03:00) Riga</option>
                                    <option data-offset="10800" value="Sofia">(GMT+03:00) Sofia</option>
                                    <option data-offset="10800" value="Tallinn">(GMT+03:00) Tallinn</option>
                                    <option data-offset="10800" value="Vilnius">(GMT+03:00) Vilnius</option>
                                    <option data-offset="10800" value="Athens">(GMT+03:00) Athens</option>
                                    <option data-offset="10800" value="Istanbul">(GMT+03:00) Istanbul</option>
                                    <option data-offset="10800" value="Minsk">(GMT+03:00) Minsk</option>
                                    <option data-offset="10800" value="Jerusalem">(GMT+03:00) Jerusalem</option>
                                    <option data-offset="10800" value="Moscow">(GMT+03:00) Moscow</option>
                                    <option data-offset="10800" value="St. Petersburg">(GMT+03:00) St. Petersburg</option>
                                    <option data-offset="10800" value="Volgograd">(GMT+03:00) Volgograd</option>
                                    <option data-offset="10800" value="Kuwait">(GMT+03:00) Kuwait</option>
                                    <option data-offset="10800" value="Riyadh">(GMT+03:00) Riyadh</option>
                                    <option data-offset="10800" value="Nairobi">(GMT+03:00) Nairobi</option>
                                    <option data-offset="10800" value="Baghdad">(GMT+03:00) Baghdad</option>
                                    <option data-offset="14400" value="Abu Dhabi">(GMT+04:00) Abu Dhabi</option>
                                    <option data-offset="14400" value="Muscat">(GMT+04:00) Muscat</option>
                                    <option data-offset="14400" value="Baku">(GMT+04:00) Baku</option>
                                    <option data-offset="14400" value="Tbilisi">(GMT+04:00) Tbilisi</option>
                                    <option data-offset="14400" value="Yerevan">(GMT+04:00) Yerevan</option>
                                    <option data-offset="16200" value="Tehran">(GMT+04:30) Tehran</option>
                                    <option data-offset="16200" value="Kabul">(GMT+04:30) Kabul</option>
                                    <option data-offset="18000" value="Ekaterinburg">(GMT+05:00) Ekaterinburg</option>
                                    <option data-offset="18000" value="Islamabad">(GMT+05:00) Islamabad</option>
                                    <option data-offset="18000" value="Karachi">(GMT+05:00) Karachi</option>
                                    <option data-offset="18000" value="Tashkent">(GMT+05:00) Tashkent</option>
                                    <option data-offset="19800" value="Chennai">(GMT+05:30) Chennai</option>
                                    <option data-offset="19800" value="Kolkata">(GMT+05:30) Kolkata</option>
                                    <option data-offset="19800" value="Mumbai">(GMT+05:30) Mumbai</option>
                                    <option data-offset="19800" value="New Delhi">(GMT+05:30) New Delhi</option>
                                    <option data-offset="19800" value="Sri Jayawardenepura">(GMT+05:30) Sri Jayawardenepura</option>
                                    <option data-offset="20700" value="Kathmandu">(GMT+05:45) Kathmandu</option>
                                    <option data-offset="21600" value="Astana">(GMT+06:00) Astana</option>
                                    <option data-offset="21600" value="Dhaka">(GMT+06:00) Dhaka</option>
                                    <option data-offset="21600" value="Almaty">(GMT+06:00) Almaty</option>
                                    <option data-offset="21600" value="Urumqi">(GMT+06:00) Urumqi</option>
                                    <option data-offset="23400" value="Rangoon">(GMT+06:30) Rangoon</option>
                                    <option data-offset="25200" value="Novosibirsk">(GMT+07:00) Novosibirsk</option>
                                    <option data-offset="25200" value="Bangkok">(GMT+07:00) Bangkok</option>
                                    <option data-offset="25200" value="Hanoi">(GMT+07:00) Hanoi</option>
                                    <option data-offset="25200" value="Jakarta">(GMT+07:00) Jakarta</option>
                                    <option data-offset="25200" value="Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                                    <option data-offset="28800" value="Beijing">(GMT+08:00) Beijing</option>
                                    <option data-offset="28800" value="Chongqing">(GMT+08:00) Chongqing</option>
                                    <option data-offset="28800" value="Hong Kong">(GMT+08:00) Hong Kong</option>
                                    <option data-offset="28800" value="Kuala Lumpur">(GMT+08:00) Kuala Lumpur</option>
                                    <option data-offset="28800" value="Singapore">(GMT+08:00) Singapore</option>
                                    <option data-offset="28800" value="Taipei">(GMT+08:00) Taipei</option>
                                    <option data-offset="28800" value="Perth">(GMT+08:00) Perth</option>
                                    <option data-offset="28800" value="Irkutsk">(GMT+08:00) Irkutsk</option>
                                    <option data-offset="28800" value="Ulaan Bataar">(GMT+08:00) Ulaan Bataar</option>
                                    <option data-offset="32400" value="Seoul">(GMT+09:00) Seoul</option>
                                    <option data-offset="32400" value="Osaka">(GMT+09:00) Osaka</option>
                                    <option data-offset="32400" value="Sapporo">(GMT+09:00) Sapporo</option>
                                    <option data-offset="32400" value="Tokyo">(GMT+09:00) Tokyo</option>
                                    <option data-offset="32400" value="Yakutsk">(GMT+09:00) Yakutsk</option>
                                    <option data-offset="34200" value="Darwin">(GMT+09:30) Darwin</option>
                                    <option data-offset="34200" value="Adelaide">(GMT+09:30) Adelaide</option>
                                    <option data-offset="36000" value="Canberra">(GMT+10:00) Canberra</option>
                                    <option data-offset="36000" value="Melbourne">(GMT+10:00) Melbourne</option>
                                    <option data-offset="36000" value="Sydney">(GMT+10:00) Sydney</option>
                                    <option data-offset="36000" value="Brisbane">(GMT+10:00) Brisbane</option>
                                    <option data-offset="36000" value="Hobart">(GMT+10:00) Hobart</option>
                                    <option data-offset="36000" value="Vladivostok">(GMT+10:00) Vladivostok</option>
                                    <option data-offset="36000" value="Guam">(GMT+10:00) Guam</option>
                                    <option data-offset="36000" value="Port Moresby">(GMT+10:00) Port Moresby</option>
                                    <option data-offset="36000" value="Solomon Is.">(GMT+10:00) Solomon Is.</option>
                                    <option data-offset="39600" value="Magadan">(GMT+11:00) Magadan</option>
                                    <option data-offset="39600" value="New Caledonia">(GMT+11:00) New Caledonia</option>
                                    <option data-offset="43200" value="Fiji">(GMT+12:00) Fiji</option>
                                    <option data-offset="43200" value="Kamchatka">(GMT+12:00) Kamchatka</option>
                                    <option data-offset="43200" value="Marshall Is.">(GMT+12:00) Marshall Is.</option>
                                    <option data-offset="43200" value="Auckland">(GMT+12:00) Auckland</option>
                                    <option data-offset="43200" value="Wellington">(GMT+12:00) Wellington</option>
                                    <option data-offset="46800" value="Nuku'alofa">(GMT+13:00) Nuku'alofa</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Communication</label>
                            <div class="col-9">
                                <div class="checkbox-inline">
                                    <label class="checkbox">
                                    <input type="checkbox" checked="checked" />
                                    <span></span>Email</label>
                                    <label class="checkbox">
                                    <input type="checkbox" checked="checked" />
                                    <span></span>SMS</label>
                                    <label class="checkbox">
                                    <input type="checkbox" />
                                    <span></span>Phone</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-10"></div>
                    <div class="my-52">
                        <h3 class="text-dark font-weight-bold mb-10">Security:</h3>
                        <div class="form-group row">
                            <label class="col-3">Login verification</label>
                            <div class="col-9">
                                <button type="button" class="btn btn-light-primary font-weight-bold btn-sm">Setup login verification</button>
                                <div class="form-text text-muted mt-3">After you log in, you will be asked for additional information to confirm your identity and protect your account from being compromised.
                                <a href="#">Learn more</a>.</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Password reset verification</label>
                            <div class="col-9">
                                <div class="checkbox-inline">
                                    <label class="checkbox mb-2">
                                    <input type="checkbox" />
                                    <span></span>Require personal information to reset your password</label>
                                </div>
                                <div class="form-text text-muted">For extra security, this requires you to confirm your email or phone number when you reset your password.
                                <a href="#" class="font-weight-bold">Learn more</a>.</div>
                            </div>
                        </div>
                        <div class="form-group row mt-10">
                            <label class="col-3"></label>
                            <div class="col-9">
                                <button type="button" class="btn btn-light-danger font-weight-bold btn-sm">Deactivate your account ?</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2"></div>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>

@endsection
