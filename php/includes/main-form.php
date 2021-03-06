<?php
    
    function sanitizeInput($str) {
        $str = trim($str);
        $str = stripslashes($str);
        $str = str_replace("'", "''", $str);
        return $str;
    }
    
    if (isset($_POST['submit'])) {
            // Set POST variables
                        
            $data = array(
			  'project_name' => "'" . sanitizeInput($_POST['project-name']) . "'",
			  'project_url' => "'" . sanitizeInput($_POST['project-url']) . "'",
			  'the_geom' => sanitizeInput($_POST['latlng']),
			  'project_description' => "'" . sanitizeInput($_POST['project-description']) . "'",
			  'field_of_science' => "'" . sanitizeInput($_POST['field-of-science']) . "'",
			  'keywords' => "'" . sanitizeInput($_POST['keywords']) . "'",
			  'status' => "'" . sanitizeInput($_POST['status']) . "'",
			  'start_date' => "'" . sanitizeInput($_POST['start-date']) . "'",
			  'agency_sponsor' => "'" . sanitizeInput($_POST['agency-sponsor']) . "'",
			  'agency_partner' => "'" . sanitizeInput($_POST['agency-partner']) . "'",
			  'geographic_scope' => "'" . sanitizeInput($_POST['geographic-scope']) . "'",
			  'age_public' => isset($_POST['age-public']) ? '1' : '0',
			  'age_families' => isset($_POST['age-families']) ? '1' : '0',
			  'age_elementary' => isset($_POST['age-elementary']) ? '1' : '0',
			  'age_middle' => isset($_POST['age-middle']) ? '1' : '0',
			  'age_teens' => isset($_POST['age-teens']) ? '1' : '0',
			  'age_seniors' => isset($_POST['age-seniors']) ? '1' : '0',
			  'outcomes_research' => isset($_POST['outcomes-research']) ? '1' : '0',
			  'outcomes_operational' => isset($_POST['outcomes-operational']) ? '1' : '0',
			  'outcomes_regulation' => isset($_POST['outcomes-regulation']) ? '1' : '0',
			  'outcomes_education' => isset($_POST['outcomes-education']) ? '1' : '0',
			  'outcomes_community' => isset($_POST['outcomes-community']) ? '1' : '0',
			  'outcomes_policy' => isset($_POST['outcomes-policy']) ? '1' : '0',
			  'outcomes_proofconcept' => isset($_POST['outcomes-proofconcept']) ? '1' : '0',
			  'outcomes_other' => isset($_POST['outcomes-other']) ? '1' : '0',
			  'audience_teachers' => isset($_POST['audience-teachers']) ? '1' : '0',
			  'audience_museum' => isset($_POST['audience-museum']) ? '1' : '0',
			  'audience_administration' => isset($_POST['audience-administration']) ? '1' : '0',
			  'audience_scientists' => isset($_POST['audience-scientists']) ? '1' : '0',
			  'audience_evaluators' => isset($_POST['audience-evaluators']) ? '1' : '0',
			  'audience_public' => isset($_POST['audience-public']) ? '1' : '0',
			  'participation_type' => "'" . sanitizeInput($_POST['participation-type']) . "'",
			  'project_contact' => "'" . sanitizeInput($_POST['project-contact']) . "'",
			  'affiliation' => "'" . sanitizeInput($_POST['affiliation']) . "'",
			  'street_address' => "'" . sanitizeInput($_POST['street-address']) . "'",
			  'street_address_2' => "'" . sanitizeInput($_POST['street-address-2']) . "'",
			  'city' => "'" . sanitizeInput($_POST['city']) . "'",
			  'state' => "'" . sanitizeInput($_POST['state']) . "'",
			  'zip' => "'" . sanitizeInput($_POST['zip']) . "'",
			  'email' => "'" . sanitizeInput($_POST['email']) . "'",
			  'phone' => "'" . sanitizeInput($_POST['phone']) . "'",

			);
			
			//print_r($data);
            		
			function insertSQL($table, $data) {
				$keys = implode(',', array_keys($data));
				$values = implode(',', array_values($data));
				$sql = "INSERT INTO $table ($keys) VALUES($values);";
				return $sql;
			}
			
			//CartoDB user name
			$cartodb_username = "inventory";
			
			//API Key (https://examples.cartodb.com/your_apps/api_key)
			$api_key= "INSERT API KEY HERE";
			
			$table = 'staging';
			
			$sql = insertSQL($table, $data);
			//print($sql);
			

			//---------------
			// Initializing curl
			$ch = curl_init( "https://".$cartodb_username.".cartodb.com/api/v2/sql" );
			$query = http_build_query(array('q'=>$sql,'api_key'=>$api_key));
			// Configuring curl options
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result_not_parsed = curl_exec($ch);
			//----------------
			
			$result = json_decode($result_not_parsed);
			
			//echo(print_r($result));
			
			if($result) {
            	header("Location: success");
            }

            
            
    }
    


?>
      <h2 class="text-center">Submit a New Project</h2>
      <div class="well">Welcome to the Federal Inventory of Crowdsourcing and Citizen Science.  Below is a two-part webform for you to fill out entirely. If at any point you do not understand the field, please refer to <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="Hover over this for more instruction"></span> for more instructions.  The information collected will be displayed on a searchable map for the public to use.  To assist in visualizing the final product, explore the <a href="browse">map</a>. For further detail on each field of science category, please visit <a href="http://sites.nationalacademies.org/pga/Resdoc/PGA_044522.htm">this website</a>.</div>

      <!-- removing row <div class="row"> -->
        <!--first column -->
		<form class="form-horizontal" method="post" action="">
	        <div class="col-xs-12">
				<fieldset>
				
				<!-- Form Name -->
				<legend class="orange"><i class="fa fa-file-text-o"></i>Project Information</legend>
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="project-name">Project Name <span data-toggle="tooltip" title="Commonly accepted name for the project" class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				  <input id="project-name" name="project-name" type="text" placeholder="" class="form-control input-md" required="">
				    
				  </div>
				</div>
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="project-url">Project URL <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="URL for project website"></span></label>  
				  <div class="col-md-6">
				  <input id="project-url" name="project-url" type="text" placeholder="http://" class="form-control input-md" required="">
				    
				  </div>
				</div>
				
				<!-- Textarea -->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="project-description">Project Description <span data-toggle="tooltip" title="1-3 sentences defining the mission statement for your project" class="glyphicon glyphicon-info-sign"></span></label>
				  <div class="col-md-6">                     
				    <textarea class="form-control" id="project-description" name="project-description"></textarea>
				  </div>
				</div>
				
				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="field-of-science">Field of Science <span data-toggle="tooltip" title="Please select one of the five categories that best defines your project. Following this field you will be able to enter keywords to further define your project." class="glyphicon glyphicon-info-sign"></span></label>
				  <div class="col-md-6">
				    <select id="field-of-science" name="field-of-science" class="form-control">
				      <option value="Life Sciences">Life Sciences</option>
				      <option value="Physical Sciences and Mathematics">Physical Sciences and Mathematics</option>
				      <option value="Engineering">Engineering</option>
				      <option value="Social and Behavioral Sciences">Social and Behavioral Sciences</option>
				      <option value="Arts and Humanities">Arts and Humanities</option>
				    </select>
				  </div>
				</div>
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="keywords">Project Keywords <span data-toggle="tooltip" title="Please enter descriptive keywords, separated by a comma, which will help someone find your project on the browsable map." class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				  <input id="keywords" name="keywords" type="text" placeholder="" class="form-control input-md">
				    
				  </div>
				</div>
				
				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="status">Project Status <span data-toggle="tooltip" title="What is the current status of this project?" class="glyphicon glyphicon-info-sign"></span></label>
				  <div class="col-md-6">
				    <select id="status" name="status" class="form-control">
				      <option value="Pending">Pending</option>
				      <option value="Active">Active</option>
				      <option value="Active but Seasonal">Active but Seasonal</option>
				      <option value="Complete">Complete</option>
				      <option value="Hiatus">Hiatus</option>
				    </select>
				  </div>
				</div>
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="start-date">Project Start Date <span data-toggle="tooltip" title="Approximately when was the grant issued, or project launched?" class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				  <input id="start-date" name="start-date" type="text" placeholder="yyyy-mm-dd" class="form-control input-md">
				    
				  </div>
				</div>
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="agency-sponsor">Agency Sponsor <span data-toggle="tooltip" title="What federal agency (or agencies) offers either primary or partial fiscal support of this project?" class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				    <select id="agency-sponsor" name="agency-sponsor" class="form-control">
				      <option value="">Choose an Agency</option>
				      <option value="Bureau of Land Management (BLM)">Bureau of Land Management (BLM)</option>
				      <option value="Department of Homeland Security (DHS)">Department of Homeland Security (DHS)</option>
				      <option value="U.S. Department of the Interior (DOI)">U.S. Department of the Interior (DOI)</option>
				      <option value="U.S. Environmental Protection Agency (EPA)">U.S. Environmental Protection Agency (EPA)</option>
				      <option value="United States Department of Health and Human Services (HHS)">United States Department of Health and Human Services (HHS)</option>
				      <option value="National Archives and Records Administration (NARA)">National Archives and Records Administration (NARA)</option>
				      <option value="National Aeronautics and Space Administration (NASA)">National Aeronautics and Space Administration (NASA)</option>
				      <option value="National Institutes of Health (NIH)">National Institutes of Health (NIH)</option>
				      <option value="National Oceanic and Atmospheric Administration (NOAA)">National Oceanic and Atmospheric Administration (NOAA)</option>
				      <option value="National Science Foundation (NSF)">National Science Foundation (NSF)</option>
				      <option value="U.S. National Park Service (NPS)">U.S. National Park Service (NPS)</option>
				      <option value="The United States Social Security Administration (SSA)">The United States Social Security Administration (SSA)</option>
				      <option value="U.S Department of State">U.S Department of State</option>
				      <option value="U.S. Department of Agriculture">U.S. Department of Agriculture</option>
				      <option value="U.S. Agency for International Development (USAID)">U.S. Agency for International Development (USAID)</option>
				      <option value="U.S. Geological Survey (USGS)">U.S. Geological Survey (USGS)</option>
				      <option value="Other legislative branch agency">Other legislative branch agency</option>
				      <option value="Other executive branch agency">Other executive branch agency</option>
				      <option value="Other judicial branch agency">Other judicial branch agency</option>
				      <option value="Other Independent agency">Other Independent agency</option>
				    </select>
				  </div>
				</div>
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="agency-partner">Agency Partner <span data-toggle="tooltip" title="A federal agency offering partial support" class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				    <select id="agency-partner" name="agency-partner" class="form-control">
				      <option value="">Choose an Agency</option>
				      <option value="Bureau of Land Management (BLM)">Bureau of Land Management (BLM)</option>
				      <option value="Department of Homeland Security (DHS)">Department of Homeland Security (DHS)</option>
				      <option value="U.S. Department of the Interior (DOI)">U.S. Department of the Interior (DOI)</option>
				      <option value="U.S. Environmental Protection Agency (EPA)">U.S. Environmental Protection Agency (EPA)</option>
				      <option value="United States Department of Health and Human Services (HHS)">United States Department of Health and Human Services (HHS)</option>
				      <option value="National Archives and Records Administration (NARA)">National Archives and Records Administration (NARA)</option>
				      <option value="National Aeronautics and Space Administration (NASA)">National Aeronautics and Space Administration (NASA)</option>
				      <option value="National Institutes of Health (NIH)">National Institutes of Health (NIH)</option>
				      <option value="National Oceanic and Atmospheric Administration (NOAA)">National Oceanic and Atmospheric Administration (NOAA)</option>
				      <option value="National Science Foundation (NSF)">National Science Foundation (NSF)</option>
				      <option value="U.S. National Park Service (NPS)">U.S. National Park Service (NPS)</option>
				      <option value="The United States Social Security Administration (SSA)">The United States Social Security Administration (SSA)</option>
				      <option value="U.S Department of State">U.S Department of State</option>
				      <option value="U.S. Department of Agriculture">U.S. Department of Agriculture</option>
				      <option value="U.S. Agency for International Development (USAID)">U.S. Agency for International Development (USAID)</option>
				      <option value="U.S. Geological Survey (USGS)">U.S. Geological Survey (USGS)</option>
				      <option value="Smithsonian Institution (SI)">Smithsonian Institution (SI)</option>
				      <option value="Other legislative branch agency">Other legislative branch agency</option>
				      <option value="Other executive branch agency">Other executive branch agency</option>
				      <option value="Other judicial branch agency">Other judicial branch agency</option>
				      <option value="Other Independent agency">Other Independent agency</option>
				    </select>
				  </div>
				</div>
				
				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="geographic-scope">Geographic Scope <span data-toggle="tooltip" title="Please select the best definition for your projects geographic scope." class="glyphicon glyphicon-info-sign"></span></label>
				  <div class="col-md-6">
				    <select id="geographic-scope" name="geographic-scope" class="form-control">
				      <option value="International">International</option>
				      <option value="National">National</option>
				      <option value="Regional">Regional</option>
				      <option value="Local">Local</option>
				    </select>
				  </div>
				</div>
				
				<!-- Multiple Checkboxes -->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="participant-age">Participant Age <span data-toggle="tooltip" title="Target age of participants" class="glyphicon glyphicon-info-sign"></span></label>
					  <div class="col-md-6">
						  <div class="checkbox">
						    <label for="age-public">
						      <input type="checkbox" name="age-public" id="age-public" value="General Public">
						      General Public
						    </label>
							</div>
						  <div class="checkbox">
						    <label for="age-families">
						      <input type="checkbox" name="age-families" id="age-families" value="Families">
						      Families
						    </label>
							</div>
						  <div class="checkbox">
						    <label for="age-elementary">
						      <input type="checkbox" name="age-elementary" id="age-elementary" value="Elementary School Children">
						      Elementary School Children
						    </label>
							</div>
						  <div class="checkbox">
						    <label for="age-middle">
						      <input type="checkbox" name="age-middle" id="age-middle" value="Middle School Children">
						      Middle School Children
						    </label>
							</div>
						  <div class="checkbox">
						    <label for="age-teens">
						      <input type="checkbox" name="age-teens" id="age-teens" value="Teens">
						      Teens
						    </label>
							</div>
						  <div class="checkbox">
						    <label for="age-seniors">
						      <input type="checkbox" name="age-seniors" id="age-seniors" value="Seniors">
						      Seniors
						    </label>
							</div>
					  </div>
				</div>
				
				<!-- Multiple Checkboxes -->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="outcomes">Intended Outcomes <span data-toggle="tooltip" title="Desired outcomes of project" class="glyphicon glyphicon-info-sign"></span></label>
				  <div class="col-md-6">
				  <div class="checkbox">
				    <label for="outcomes-research">
				      <input type="checkbox" name="outcomes-research" id="outcomes-research" value="Research Advancement">
				      Research Advancement
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="outcomes-operational">
				      <input type="checkbox" name="outcomes-operational" id="outcomes-operational" value="Operational Integration or Use">
				      Operational Integration or Use
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="outcomes-regulation">
				      <input type="checkbox" name="outcomes-regulation" id="outcomes-regulation" value="Regulation">
				      Regulation
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="outcomes-education">
				      <input type="checkbox" name="outcomes-education" id="outcomes-education" value="Education / Outreach">
				      Education
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="outcomes-community">
				      <input type="checkbox" name="outcomes-community" id="outcomes-community" value="Community Engagement / Outreach">
				      Community Engagement / Outreach
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="outcomes-policy">
				      <input type="checkbox" name="outcomes-policy" id="outcomes-policy" value="Inform Public Policy">
				      Inform Public Policy
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="outcomes-proofconcept">
				      <input type="checkbox" name="outcomes-proofconcept" id="outcomes-proofconcept" value="Proof of Concept">
				      Proof of Concept
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="outcomes-other">
				      <input type="checkbox" name="outcomes-other" id="outcomes-other" value="Other">
				      Other
				    </label>
					</div>
				  </div>
				</div>
				
				<!-- Multiple Checkboxes -->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="audience">Intended Audience <span data-toggle="tooltip" title="Which audiences is this project designed to support?" class="glyphicon glyphicon-info-sign"></span></label>
				  <div class="col-md-6">
				  <div class="checkbox">
				    <label for="audience-teachers">
				      <input type="checkbox" name="audience-teachers" id="audience-teachers" value="Educators / Teachers">
				      Educators / Teachers
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="audience-museum">
				      <input type="checkbox" name="audience-museum" id="audience-museum" value="Museum / ISE Professionals">
				      Museum / ISE Professionals
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="audience-administration">
				      <input type="checkbox" name="audience-administration" id="audience-administration" value="Administration / Leadership / Policymakers">
				      Administration / Leadership / Policymakers
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="audience-scientists">
				      <input type="checkbox" name="audience-scientists" id="audience-scientists" value="Scientists">
				      Scientists
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="audience-evaluators">
				      <input type="checkbox" name="audience-evaluators" id="audience-evaluators" value="Evaluators">
				      Evaluators
				    </label>
					</div>
				  <div class="checkbox">
				    <label for="audience-public">
				      <input type="checkbox" name="audience-public" id="audience-public" value="General Public">
				      General Public
				    </label>
					</div>
				  </div>
				</div>
				
				<!-- Textarea -->
				<div class="form-group">
				  <label class="col-md-4 control-label orange" for="participation-type">Participation Type <span data-toggle="tooltip" title="Description of volunteer activities" class="glyphicon glyphicon-info-sign"></span></label>
				  <div class="col-md-6">                     
				    <textarea class="form-control" id="participation-type" name="participation-type"></textarea>
				  </div>
				</div>
				
				</fieldset>
	
	        </div>
	        <!--second column -->

	        <div class="col-xs-12">

				<fieldset>				
				<!-- Form Name -->
				<legend class="blue"><i class="fa fa-map-marker"></i>Location Information</legend>

				<div class="well">
					<p>Please enter the address where the project is administered.  For example, if your project crowdsources identification of images, then where is the project and its dataset managed?  OR if your project conducts water quality monitoring across a tri-state water feature then where is that data collected and managed?</p>
					<p>After you enter an address and click the "Geocode Address" button, a pin will be placed on the map. To move the pin, click the edit button in the map and drag it to the most appropriate location. If you don't have an address, click the pin button on the left side of the map toolbar to draw the location.</p>
					<p>If the project you are entering is only funded by your agency and all other aspects of the project are conducted on site, then please enter the address location of the projects field/administration site. </p>
				</div>

				<div class="row">
					<div class="col-md-6" id="input-map">
						map
					</div>	
					
					<div class="col-md-6" id="address">
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label light-blue" for="street-address">Street Address <span data-toggle="tooltip" title="Physical contact address" class="glyphicon glyphicon-info-sign"></span></label>  
						  <div class="col-md-6">
						  <input id="street-address" name="street-address" type="text" placeholder="" class="form-control input-md">
						    
						  </div>
						</div>
						
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label light-blue" for="street-address-2"></label>  
						  <div class="col-md-6">
						  <input id="street-address-2" name="street-address-2" type="text" placeholder="" class="form-control input-md">
						    
						  </div>
						</div>
						
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label light-blue" for="city">City</label>  
						  <div class="col-md-6">
						  <input id="city" name="city" type="text" placeholder="" class="form-control input-md">
						    
						  </div>
						</div>
						
						<!-- Select Basic -->
						<div class="form-group">
						  <label class="col-md-4 control-label light-blue" for="state">State</label>
						  <div class="col-md-6">
						    <select id="state" name="state" class="form-control">
						      <option value="AL">AL</option>
						      <option value="AK">AK</option>
						      <option value="AZ">AZ</option>
						      <option value="AR">AR</option>
						      <option value="CA">CA</option>
						      <option value="CO">CO</option>
						      <option value="CT">CT</option>
						      <option value="DC">DC</option>
						      <option value="DE">DE</option>
						      <option value="FL">FL</option>
						      <option value="GA">GA</option>
						      <option value="HI">HI</option>
						      <option value="ID">ID</option>
						      <option value="IL">IL</option>
						      <option value="IN">IN</option>
						      <option value="IA">IA</option>
						      <option value="KS">KS</option>
						      <option value="KY">KY</option>
						      <option value="LA">LA</option>
						      <option value="ME">ME</option>
						      <option value="MD">MD</option>
						      <option value="MA">MA</option>
						      <option value="MI">MI</option>
						      <option value="MN">MN</option>
						      <option value="MS">MS</option>
						      <option value="MO">MO</option>
						      <option value="MT">MT</option>
						      <option value="NE">NE</option>
						      <option value="NV">NV</option>
						      <option value="NH">NH</option>
						      <option value="NJ">NJ</option>
						      <option value="NM">NM</option>
						      <option value="NY">NY</option>
						      <option value="NC">NC</option>
						      <option value="ND">ND</option>
						      <option value="OH">OH</option>
						      <option value="OK">OK</option>
						      <option value="OR">OR</option>
						      <option value="PA">PA</option>
						      <option value="RI">RI</option>
						      <option value="SC">SC</option>
						      <option value="SD">SD</option>
						      <option value="TN">TN</option>
						      <option value="TX">TX</option>
						      <option value="UT">UT</option>
						      <option value="VT">VT</option>
						      <option value="VA">VA</option>
						      <option value="WA">WA</option>
						      <option value="WV">WV</option>
						      <option value="WI">WI</option>
						      <option value="WY">WY</option>
						      <option value="GU">GU</option>
						      <option value="PR">PR</option>
						      <option value="VI">VI</option>
						    </select>
						  </div>
						</div>
						
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-4 control-label light-blue" for="zip">Zip Code</label>  
						  <div class="col-md-6">
						  <input id="zip" name="zip" type="text" placeholder="" class="form-control input-md">
						    
						  </div>
						</div>
						
						<div class="form-group">
						  <div class="col-md-4 col-md-offset-4">
						    <button type="button" id="geocode" name="geocode" class="btn btn-primary">Geocode Address</button>
						  </div>
						</div>
						
					</div>
					
					
				</div>
				<input type="hidden" name="latlng" id="latlng" value="">
				
				<legend class="light-blue"><i class="fa fa-phone"></i>Contact Information</legend>				
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label light-blue" for="project-contact">Project Contact <span data-toggle="tooltip" title="Name of project contact" class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				  <input id="project-contact" name="project-contact" type="text" placeholder="" class="form-control input-md" required="">
				    
				  </div>
				</div>
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label light-blue" for="affiliation">Contact Affiliation <span data-toggle="tooltip" title="Affiliation of project contact" class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				  <input id="affiliation" name="affiliation" type="text" placeholder="" class="form-control input-md">
				    
				  </div>
				</div>
				

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label light-blue" for="email">Contact Email <span data-toggle="tooltip" title="Contact email address" class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				  <input id="email" name="email" type="text" placeholder="" class="form-control input-md">
				    
				  </div>
				</div>
				
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label light-blue" for="phone">Contact Phone <span data-toggle="tooltip" title="Contact phone number" class="glyphicon glyphicon-info-sign"></span></label>  
				  <div class="col-md-6">
				  <input id="phone" name="phone" type="text" placeholder="123-456-7890" class="form-control input-md">
				    
				  </div>
				</div>
				
				<div class="panel panel-info">
				  <div class="panel-heading">
				    <h3 class="panel-title text-center">That's everything!</h3>
				  </div>
				</div>				

				<!-- Button -->
					<div class="form-group">
					  <div class="col-md-4 col-md-offset-4">
					    <button id="submit" name="submit" class="btn btn-primary">Submit Entire Form</button>
					  </div>
					</div>
				
				</fieldset>
		        
	        </div>
		</form>
      <!-- removing row </div> -->

    
