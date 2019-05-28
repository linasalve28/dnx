<?php

function pb_create_countrylist($name,$selected_country="AL"){
	$country = pb_get_country_list(); 
	$country_select_box = '';
	$country_select_box.= "<select name='".$name."' id='".$name."' class='form-control' tabindex='-1' data-placeholder='Select a country'>" ;
	foreach($country as $key => $val){
		$selected = '';
		if($key==$selected_country){
			$selected = "selected";
		}
		$country_select_box .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>' ;
	}
	$country_select_box .= '</select>';
	echo $country_select_box;
}

/*
function create_countrylist($name,$selected){
  $selected="AL";
  ?>
  <select name="<?php echo $name; ?>" id="<?php echo $name; ?>" class="form-control" tabindex="-1"  data-placeholder="Select a country">
  <option value=""><?php echo $selected;?></option>
  <option value="EU" <?php if ($selected=="EU") echo "selected"; ?>>European Union</option>
  <option value="AF" <?php if ($selected=="AF") echo "selected"; ?>>Afghanistan</option>
  <option value="AL" <?php if ($selected=="AL"){ echo "selected"; }?>>Albania</option>
  <option value="DZ" <?php if ($selected=="DZ") { echo "selected"; }?>>Algeria</option>
  <option value="AS" <?php if ($selected=="AS") { echo "selected"; }?>>American Samoa</option>
  <option value="AD" <?php if ($selected=="AD") { echo "selected"; }?>>Andorra</option>
  <option value="AO" <?php if ($selected=="AO") { echo "selected"; }?>>Angola</option>
  <option value="AI" <?php if ($selected=="AI") { echo "selected"; }?>>Anguilla</option>
  <option value="AQ" <?php if ($selected=="AQ") { echo "selected"; }?>>Antarctica</option>
  <option value="AR" <?php if ($selected=="AR") { echo "selected"; }?>>Argentina</option>
  <option value="AM" <?php if ($selected=="AM") { echo "selected"; }?>>Armenia</option>
  <option value="AW" <?php if ($selected=="AW") { echo "selected"; }?>>Aruba</option>
  <option value="AU" <?php if ($selected=="AU") { echo "selected"; }?>>Australia</option>
  <option value="AT" <?php if ($selected=="AT") { echo "selected"; }?>>Austria</option>
  <option value="AZ" <?php if ($selected=="AZ") { echo "selected"; }?>>Azerbaijan</option>
  <option value="BS" <?php if ($selected=="BS") { echo "selected"; }?>>Bahamas</option>
  <option value="BH" <?php if ($selected=="BH") { echo "selected"; }?>>Bahrain</option>
  <option value="BD" <?php if ($selected=="BD") { echo "selected"; }?>>Bangladesh</option>
  <option value="BB" <?php if ($selected=="BB") { echo "selected"; }?>>Barbados</option>
  <option value="BY" <?php if ($selected=="BY") { echo "selected"; }?>>Belarus</option>
  <option value="BE" <?php if ($selected=="BE") { echo "selected"; }?>>Belgium</option>
  <option value="BZ" <?php if ($selected=="BZ") { echo "selected"; }?>>Belize</option>
  <option value="BJ" <?php if ($selected=="BJ") { echo "selected"; }?>>Benin</option>
  <option value="BM" <?php if ($selected=="BM") { echo "selected"; }?>>Bermuda</option>
  <option value="BT" <?php if ($selected=="BT") { echo "selected"; }?>>Bhutan</option>
  <option value="BO" <?php if ($selected=="BO") { echo "selected"; }?>>Bolivia</option>
  <option value="BA" <?php if ($selected=="BA") { echo "selected"; }?>>Bosnia and Herzegowina</option>
  <option value="BW" <?php if ($selected=="BW") { echo "selected"; }?>>Botswana</option>
  <option value="BV" <?php if ($selected=="BV") { echo "selected"; }?>>Bouvet Island</option>
  <option value="BR" <?php if ($selected=="BR") { echo "selected"; }?>>Brazil</option>
  <option value="IO" <?php if ($selected=="IO") { echo "selected"; }?>>British Indian Ocean Territory</option>
  <option value="BN" <?php if ($selected=="BN") { echo "selected"; }?>>Brunei Darussalam</option>
  <option value="BG" <?php if ($selected=="BG") { echo "selected"; }?>>Bulgaria</option>
  <option value="BF" <?php if ($selected=="BF") { echo "selected"; }?>>Burkina Faso</option>
  <option value="BI" <?php if ($selected=="BI") { echo "selected"; }?>>Burundi</option>
  <option value="KH" <?php if ($selected=="KH") { echo "selected"; }?>>Cambodia</option>
  <option value="CM" <?php if ($selected=="CM") { echo "selected"; }?>>Cameroon</option>
  <option value="CA" <?php if ($selected=="CA") { echo "selected"; }?>>Canada</option>
  <option value="CV" <?php if ($selected=="CV") { echo "selected"; }?>>Cape Verde</option>
  <option value="KY" <?php if ($selected=="KY") { echo "selected"; }?>>Cayman Islands</option>
  <option value="CF" <?php if ($selected=="CF") { echo "selected"; }?>>Central African Republic</option>
  <option value="TD" <?php if ($selected=="TD") { echo "selected"; }?>>Chad</option>
  <option value="CL" <?php if ($selected=="CL") { echo "selected"; }?>>Chile</option>
  <option value="CN" <?php if ($selected=="CN") { echo "selected"; }?>>China</option>
  <option value="CX" <?php if ($selected=="CX") { echo "selected"; }?>>Christmas Island</option>
  <option value="CC" <?php if ($selected=="CC") { echo "selected"; }?>>Cocos (Keeling) Islands</option>
  <option value="CO" <?php if ($selected=="CO") { echo "selected"; }?>>Colombia</option>
  <option value="KM" <?php if ($selected=="KM") { echo "selected"; }?>>Comoros</option>
  <option value="CG" <?php if ($selected=="CG") { echo "selected"; }?>>Congo</option>
  <option value="CD" <?php if ($selected=="CD") { echo "selected"; }?>>Congo, the Democratic Republic of the</option>
  <option value="CK" <?php if ($selected=="CK") { echo "selected"; }?>>Cook Islands</option>
  <option value="CR" <?php if ($selected=="CR") { echo "selected"; }?>>Costa Rica</option>
  <option value="CI" <?php if ($selected=="CI") { echo "selected"; }?>>Cote d'Ivoire</option>
  <option value="HR" <?php if ($selected=="HR") { echo "selected"; }?>>Croatia (Hrvatska)</option>
  <option value="CU" <?php if ($selected=="CU") { echo "selected"; }?>>Cuba</option>
  <option value="CY" <?php if ($selected=="CY") { echo "selected"; }?>>Cyprus</option>
  <option value="CZ" <?php if ($selected=="CZ") { echo "selected"; }?>>Czech Republic</option>
  <option value="DK" <?php if ($selected=="DK") { echo "selected"; }?>>Denmark</option>
  <option value="DJ" <?php if ($selected=="DJ") { echo "selected"; }?>>Djibouti</option>
  <option value="DM" <?php if ($selected=="DM") { echo "selected"; }?>>Dominica</option>
  <option value="DO" <?php if ($selected=="DO") { echo "selected"; }?>>Dominican Republic</option>
  <option value="EC" <?php if ($selected=="EC") { echo "selected"; }?>>Ecuador</option>
  <option value="EG" <?php if ($selected=="EG") { echo "selected"; }?>>Egypt</option>
  <option value="SV" <?php if ($selected=="SV") { echo "selected"; }?>>El Salvador</option>
  <option value="GQ" <?php if ($selected=="GQ") { echo "selected"; }?>>Equatorial Guinea</option>
  <option value="ER" <?php if ($selected=="ER") { echo "selected"; }?>>Eritrea</option>
  <option value="EE" <?php if ($selected=="EE") { echo "selected"; }?>>Estonia</option>
  <option value="ET" <?php if ($selected=="ET") { echo "selected"; }?>>Ethiopia</option>
  <option value="FK" <?php if ($selected=="FK") { echo "selected"; }?>>Falkland Islands (Malvinas)</option>
  <option value="FO" <?php if ($selected=="FO") { echo "selected"; }?>>Faroe Islands</option>
  <option value="FJ" <?php if ($selected=="FJ") { echo "selected"; }?>>Fiji</option>
  <option value="FI" <?php if ($selected=="FI") { echo "selected"; }?>>Finland</option>
  <option value="FR" <?php if ($selected=="FR") { echo "selected"; }?>>France</option>
  <option value="GF" <?php if ($selected=="GF") { echo "selected"; }?>>French Guiana</option>
  <option value="PF" <?php if ($selected=="PF") { echo "selected"; }?>>French Polynesia</option>
  <option value="TF" <?php if ($selected=="TF") { echo "selected"; }?>>French Southern Territories</option>
  <option value="GA" <?php if ($selected=="GA") { echo "selected"; }?>>Gabon</option>
  <option value="GM" <?php if ($selected=="GM") { echo "selected"; }?>>Gambia</option>
  <option value="GE" <?php if ($selected=="GE") { echo "selected"; }?>>Georgia</option>
  <option value="DE" <?php if ($selected=="DE") { echo "selected"; }?>>Germany</option>
  <option value="GH" <?php if ($selected=="GH") { echo "selected"; }?>>Ghana</option>
  <option value="GI" <?php if ($selected=="GI") { echo "selected"; }?>>Gibraltar</option>
  <option value="GR" <?php if ($selected=="GR") { echo "selected"; }?>>Greece</option>
  <option value="GL" <?php if ($selected=="GL") { echo "selected"; }?>>Greenland</option>
  <option value="GD" <?php if ($selected=="GD") { echo "selected"; }?>>Grenada</option>
  <option value="GP" <?php if ($selected=="GP") { echo "selected"; }?>>Guadeloupe</option>
  <option value="GU" <?php if ($selected=="GU") { echo "selected"; }?>>Guam</option>
  <option value="GT" <?php if ($selected=="GT") { echo "selected"; }?>>Guatemala</option>
  <option value="GN" <?php if ($selected=="GN") { echo "selected"; }?>>Guinea</option>
  <option value="GW" <?php if ($selected=="GW") { echo "selected"; }?>>Guinea-Bissau</option>
  <option value="GY" <?php if ($selected=="GY") { echo "selected"; }?>>Guyana</option>
  <option value="HT" <?php if ($selected=="HT") { echo "selected"; }?>>Haiti</option>
  <option value="HM" <?php if ($selected=="HM") { echo "selected"; }?>>Heard and Mc Donald Islands</option>
  <option value="VA" <?php if ($selected=="VA") { echo "selected"; }?>>Holy See (Vatican City State)</option>
  <option value="HN" <?php if ($selected=="HN") { echo "selected"; }?>>Honduras</option>
  <option value="HK" <?php if ($selected=="HK") { echo "selected"; }?>>Hong Kong</option>
  <option value="HU" <?php if ($selected=="HU") { echo "selected"; }?>>Hungary</option>
  <option value="IS" <?php if ($selected=="IS") { echo "selected"; }?>>Iceland</option>
  <option value="IN" <?php if ($selected=="IN") { echo "selected"; }?>>India</option>
  <option value="ID" <?php if ($selected=="ID") { echo "selected"; }?>>Indonesia</option>
  <option value="IR" <?php if ($selected=="IR") { echo "selected"; }?>>Iran (Islamic Republic of)</option>
  <option value="IQ" <?php if ($selected=="IQ") { echo "selected"; }?>>Iraq</option>
  <option value="IE" <?php if ($selected=="IE") { echo "selected"; }?>>Ireland</option>
  <option value="IL" <?php if ($selected=="IL") { echo "selected"; }?>>Israel</option>
  <option value="IT" <?php if ($selected=="IT") { echo "selected"; }?>>Italy</option>
  <option value="JM" <?php if ($selected=="JM") { echo "selected"; }?>>Jamaica</option>
  <option value="JP" <?php if ($selected=="JP") { echo "selected"; }?>>Japan</option>
  <option value="JO" <?php if ($selected=="JO") { echo "selected"; }?>>Jordan</option>
  <option value="KZ" <?php if ($selected=="KZ") { echo "selected"; }?>>Kazakhstan</option>
  <option value="KE" <?php if ($selected=="KE") { echo "selected"; }?>>Kenya</option>
  <option value="KI" <?php if ($selected=="KI") { echo "selected"; }?>>Kiribati</option>
  <option value="KP" <?php if ($selected=="KP") { echo "selected"; }?>>Korea, Democratic People's Republic of</option>
  <option value="KR" <?php if ($selected=="KR") { echo "selected"; }?>>Korea, Republic of</option>
  <option value="KW" <?php if ($selected=="KW") { echo "selected"; }?>>Kuwait</option>
  <option value="KG" <?php if ($selected=="KG") { echo "selected"; }?>>Kyrgyzstan</option>
  <option value="LA" <?php if ($selected=="LA") { echo "selected"; }?>>Lao People's Democratic Republic</option>
  <option value="LV" <?php if ($selected=="LV") { echo "selected"; }?>>Latvia</option>
  <option value="LB" <?php if ($selected=="LB") { echo "selected"; }?>>Lebanon</option>
  <option value="LS" <?php if ($selected=="LS") { echo "selected"; }?>>Lesotho</option>
  <option value="LR" <?php if ($selected=="LR") { echo "selected"; }?>>Liberia</option>
  <option value="LY" <?php if ($selected=="LY") { echo "selected"; }?>>Libyan Arab Jamahiriya</option>
  <option value="LI" <?php if ($selected=="LI") { echo "selected"; }?>>Liechtenstein</option>
  <option value="LT" <?php if ($selected=="LT") { echo "selected"; }?>>Lithuania</option>
  <option value="LU" <?php if ($selected=="LU") { echo "selected"; }?>>Luxembourg</option>
  <option value="MO" <?php if ($selected=="MO") { echo "selected"; }?>>Macau</option>
  <option value="MK" <?php if ($selected=="MK") { echo "selected"; }?>>Macedonia, The Former Yugoslav Republic of</option>
  <option value="MG" <?php if ($selected=="MG") { echo "selected"; }?>>Madagascar</option>
  <option value="MW" <?php if ($selected=="MW") { echo "selected"; }?>>Malawi</option>
  <option value="MY" <?php if ($selected=="MY") { echo "selected"; }?>>Malaysia</option>
  <option value="MV" <?php if ($selected=="MV") { echo "selected"; }?>>Maldives</option>
  <option value="ML" <?php if ($selected=="ML") { echo "selected"; }?>>Mali</option>
  <option value="MT" <?php if ($selected=="MT") { echo "selected"; }?>>Malta</option>
  <option value="MH" <?php if ($selected=="MH") { echo "selected"; }?>>Marshall Islands</option>
  <option value="MQ" <?php if ($selected=="MQ") { echo "selected"; }?>>Martinique</option>
  <option value="MR" <?php if ($selected=="MR") { echo "selected"; }?>>Mauritania</option>
  <option value="MU" <?php if ($selected=="MU") { echo "selected"; }?>>Mauritius</option>
  <option value="YT" <?php if ($selected=="YT") { echo "selected"; }?>>Mayotte</option>
  <option value="MX" <?php if ($selected=="MX") { echo "selected"; }?>>Mexico</option>
  <option value="FM" <?php if ($selected=="FM") { echo "selected"; }?>>Micronesia, Federated States of</option>
  <option value="MD" <?php if ($selected=="MD") { echo "selected"; }?>>Moldova, Republic of</option>
  <option value="MC" <?php if ($selected=="MC") { echo "selected"; }?>>Monaco</option>
  <option value="MN" <?php if ($selected=="MN") { echo "selected"; }?>>Mongolia</option>
  <option value="MS" <?php if ($selected=="MS") { echo "selected"; }?>>Montserrat</option>
  <option value="MA" <?php if ($selected=="MA") { echo "selected"; }?>>Morocco</option>
  <option value="MZ" <?php if ($selected=="MZ") { echo "selected"; }?>>Mozambique</option>
  <option value="MM" <?php if ($selected=="MM") { echo "selected"; }?>>Myanmar</option>
  <option value="NA" <?php if ($selected=="NA") { echo "selected"; }?>>Namibia</option>
  <option value="NR" <?php if ($selected=="NR") { echo "selected"; }?>>Nauru</option>
  <option value="NP" <?php if ($selected=="NP") { echo "selected"; }?>>Nepal</option>
  <option value="NL" <?php if ($selected=="NL") { echo "selected"; }?>>Netherlands</option>
  <option value="AN" <?php if ($selected=="AN") { echo "selected"; }?>>Netherlands Antilles</option>
  <option value="NC" <?php if ($selected=="NC") { echo "selected"; }?>>New Caledonia</option>
  <option value="NZ" <?php if ($selected=="NZ") { echo "selected"; }?>>New Zealand</option>
  <option value="NI" <?php if ($selected=="NI") { echo "selected"; }?>>Nicaragua</option>
  <option value="NE" <?php if ($selected=="NE") { echo "selected"; }?>>Niger</option>
  <option value="NG" <?php if ($selected=="NG") { echo "selected"; }?>>Nigeria</option>
  <option value="NU" <?php if ($selected=="NU") { echo "selected"; }?>>Niue</option>
  <option value="NF" <?php if ($selected=="NF") { echo "selected"; }?>>Norfolk Island</option>
  <option value="MP" <?php if ($selected=="MP") { echo "selected"; }?>>Northern Mariana Islands</option>
  <option value="NO" <?php if ($selected=="NO") { echo "selected"; }?>>Norway</option>
  <option value="OM" <?php if ($selected=="OM") { echo "selected"; }?>>Oman</option>
  <option value="PK" <?php if ($selected=="PK") { echo "selected"; }?>>Pakistan</option>
  <option value="PW" <?php if ($selected=="PW") { echo "selected"; }?>>Palau</option>
  <option value="PA" <?php if ($selected=="PA") { echo "selected"; }?>>Panama</option>
  <option value="PG" <?php if ($selected=="PG") { echo "selected"; }?>>Papua New Guinea</option>
  <option value="PY" <?php if ($selected=="PY") { echo "selected"; }?>>Paraguay</option>
  <option value="PE" <?php if ($selected=="PE") { echo "selected"; }?>>Peru</option>
  <option value="PH" <?php if ($selected=="PH") { echo "selected"; }?>>Philippines</option>
  <option value="PN" <?php if ($selected=="PN") { echo "selected"; }?>>Pitcairn</option>
  <option value="PL" <?php if ($selected=="PL") { echo "selected"; }?>>Poland</option>
  <option value="PT" <?php if ($selected=="PT") { echo "selected"; }?>>Portugal</option>
  <option value="PR" <?php if ($selected=="PR") { echo "selected"; }?>>Puerto Rico</option>
  <option value="QA" <?php if ($selected=="QA") { echo "selected"; }?>>Qatar</option>
  <option value="RE" <?php if ($selected=="RE") { echo "selected"; }?>>Reunion</option>
  <option value="RO" <?php if ($selected=="RO") { echo "selected"; }?>>Romania</option>
  <option value="RU" <?php if ($selected=="RU") { echo "selected"; }?>>Russian Federation</option>
  <option value="RW" <?php if ($selected=="RW") { echo "selected"; }?>>Rwanda</option>
  <option value="KN" <?php if ($selected=="KN") { echo "selected"; }?>>Saint Kitts and Nevis</option>
  <option value="LC" <?php if ($selected=="LC") { echo "selected"; }?>>Saint LUCIA</option>
  <option value="VC" <?php if ($selected=="VC") { echo "selected"; }?>>Saint Vincent and the Grenadines</option>
  <option value="WS" <?php if ($selected=="WS") { echo "selected"; }?>>Samoa</option>
  <option value="SM" <?php if ($selected=="SM") { echo "selected"; }?>>San Marino</option>
  <option value="ST" <?php if ($selected=="ST") { echo "selected"; }?>>Sao Tome and Principe</option>
  <option value="SA" <?php if ($selected=="SA") { echo "selected"; }?>>Saudi Arabia</option>
  <option value="SN" <?php if ($selected=="SN") { echo "selected"; }?>>Senegal</option>
  <option value="SC" <?php if ($selected=="SC") { echo "selected"; }?>>Seychelles</option>
  <option value="SL" <?php if ($selected=="SL") { echo "selected"; }?>>Sierra Leone</option>
  <option value="SG" <?php if ($selected=="SG") { echo "selected"; }?>>Singapore</option>
  <option value="SK" <?php if ($selected=="SK") { echo "selected"; }?>>Slovakia (Slovak Republic)</option>
  <option value="SI" <?php if ($selected=="SI") { echo "selected"; }?>>Slovenia</option>
  <option value="SB" <?php if ($selected=="SB") { echo "selected"; }?>>Solomon Islands</option>
  <option value="SO" <?php if ($selected=="SO") { echo "selected"; }?>>Somalia</option>
  <option value="ZA" <?php if ($selected=="ZA") { echo "selected"; }?>>South Africa</option>
  <option value="GS" <?php if ($selected=="GS") { echo "selected"; }?>>South Georgia and the South Sandwich Islands</option>
  <option value="ES" <?php if ($selected=="ES") { echo "selected"; }?>>Spain</option>
  <option value="LK" <?php if ($selected=="LK") { echo "selected"; }?>>Sri Lanka</option>
  <option value="SH" <?php if ($selected=="SH") { echo "selected"; }?>>St. Helena</option>
  <option value="PM" <?php if ($selected=="PM") { echo "selected"; }?>>St. Pierre and Miquelon</option>
  <option value="SD" <?php if ($selected=="SD") { echo "selected"; }?>>Sudan</option>
  <option value="SR" <?php if ($selected=="SR") { echo "selected"; }?>>Suriname</option>
  <option value="SJ" <?php if ($selected=="SJ") { echo "selected"; }?>>Svalbard and Jan Mayen Islands</option>
  <option value="SZ" <?php if ($selected=="SZ") { echo "selected"; }?>>Swaziland</option>
  <option value="SE" <?php if ($selected=="SE") { echo "selected"; }?>>Sweden</option>
  <option value="CH" <?php if ($selected=="CH") { echo "selected"; }?>>Switzerland</option>
  <option value="SY" <?php if ($selected=="SY") { echo "selected"; }?>>Syrian Arab Republic</option>
  <option value="TW" <?php if ($selected=="TW") { echo "selected"; }?>>Taiwan, Province of China</option>
  <option value="TJ" <?php if ($selected=="TJ") { echo "selected"; }?>>Tajikistan</option>
  <option value="TZ" <?php if ($selected=="TZ") { echo "selected"; }?>>Tanzania, United Republic of</option>
  <option value="TH" <?php if ($selected=="TH") { echo "selected"; }?>>Thailand</option>
  <option value="TG" <?php if ($selected=="TG") { echo "selected"; }?>>Togo</option>
  <option value="TK" <?php if ($selected=="TK") { echo "selected"; }?>>Tokelau</option>
  <option value="TO" <?php if ($selected=="TO") { echo "selected"; }?>>Tonga</option>
  <option value="TT" <?php if ($selected=="TT") { echo "selected"; }?>>Trinidad and Tobago</option>
  <option value="TN" <?php if ($selected=="TN") { echo "selected"; }?>>Tunisia</option>
  <option value="TR" <?php if ($selected=="TR") { echo "selected"; }?>>Turkey</option>
  <option value="TM" <?php if ($selected=="TM") { echo "selected"; }?>>Turkmenistan</option>
  <option value="TC" <?php if ($selected=="TC") { echo "selected"; }?>>Turks and Caicos Islands</option>
  <option value="TV" <?php if ($selected=="TV") { echo "selected"; }?>>Tuvalu</option>
  <option value="UG" <?php if ($selected=="UG") { echo "selected"; }?>>Uganda</option>
  <option value="UA" <?php if ($selected=="UA") { echo "selected"; }?>>Ukraine</option>
  <option value="AE" <?php if ($selected=="AE") { echo "selected"; }?>>United Arab Emirates</option>
  <option value="GB" <?php if ($selected=="GB") { echo "selected"; }?>>United Kingdom</option>
  <option value="US" <?php if ($selected=="US") { echo "selected"; }?>>United States</option>
  <option value="UM" <?php if ($selected=="UM") { echo "selected"; }?>>United States Minor Outlying Islands</option>
  <option value="UY" <?php if ($selected=="UY") { echo "selected"; }?>>Uruguay</option>
  <option value="UZ" <?php if ($selected=="UZ") { echo "selected"; }?>>Uzbekistan</option>
  <option value="VU" <?php if ($selected=="VU") { echo "selected"; }?>>Vanuatu</option>
  <option value="VE" <?php if ($selected=="VE") { echo "selected"; }?>>Venezuela</option>
  <option value="VN" <?php if ($selected=="VN") { echo "selected"; }?>>Viet Nam</option>
  <option value="VG" <?php if ($selected=="VG") { echo "selected"; }?>>Virgin Islands (British)</option>
  <option value="VI" <?php if ($selected=="VI") { echo "selected"; }?>>Virgin Islands (U.S.)</option>
  <option value="WF" <?php if ($selected=="WF") { echo "selected"; }?>>Wallis and Futuna Islands</option>
  <option value="EH" <?php if ($selected=="EH") { echo "selected"; }?>>Western Sahara</option>
  <option value="YE" <?php if ($selected=="YE") { echo "selected"; }?>>Yemen</option>
  <option value="ZM" <?php if ($selected=="ZM") { echo "selected"; }?>>Zambia</option>
  <option value="ZW" <?php if ($selected=="ZW") { echo "selected"; }?>>Zimbabwe</option>
</select>
<?php
}?>
*/