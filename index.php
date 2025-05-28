<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html>

<head>

	<title>Local Service Search Engine|| Home Page</title>

	<!--================================BOOTSTRAP STYLE SHEETS================================-->

	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

	<!--================================ Main STYLE SHEETs====================================-->

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/color/color.css">
	<link rel="stylesheet" type="text/css" href="assets/testimonial/css/style.css" />
	<link rel="stylesheet" type="text/css" href="assets/testimonial/css/elastislide.css" />
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

	<!--================================FONTAWESOME==========================================-->

	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">

	<!--================================GOOGLE FONTS=========================================-->
	<link rel='stylesheet' type='text/css'
		href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Lato:300,400,700,900'>

	<!--================================SLIDER REVOLUTION =========================================-->

	<link rel="stylesheet" type="text/css" href="assets/revolution_slider/css/revslider.css" media="screen" />

	<!--================================LEAFLET CSS =========================================-->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

	<style>
		#map {
			height: 400px;
			width: 100%;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}

		.main-content-section {
			padding: 40px 0;
		}

		.category-column {
			margin-bottom: 20px;
		}

		.map-column {
			margin-bottom: 20px;
		}
	</style>

</head>

<body>
	<div class="theme-wrap clearfix">
		<!--================================responsive log and menu==========================================-->
		<!-- <div class="wsmenucontent overlapblackbg"></div>
		<div class="wsmenuexpandermain slideRight">
			<a id="navToggle" class="animated-arrow slideLeft"><span></span></a>
			<a href="#" class="smallogo"><img src="images/logo.png" width="120" alt="" /></a>
		</div> -->
		<?php include_once('includes/header.php'); ?>

		<!--================================Revolution SLIDER SECTION==========================================-->

		<section id="slider-revolution">
			<div class="fullwidthbanner-container">
				<div class="revolution-slider tx-center">
					<ul><!-- SLIDE  -->

						<!-- Slide1 -->
						<li data-transition="slideright" data-slotamount="5" data-masterspeed="1000">
							<!-- MAIN IMAGE -->
							<img src="images/Home-Services-Apps.jpeg" alt="item slide">
							<!-- LAYERS -->
						</li>
					</ul>
				</div>
			</div>
		</section>

		<section class="main-content-section padding-top-20 padding-bottom-40">
			<div class="container"><!-- section container -->
				<div class="row">
					<!-- LEFT SIDE - CATEGORY SECTION -->
					<div class="col-md-5 col-sm-12 category-column">
						<div class="section-title-wrap margin-bottom-30"><!-- section title -->
							<h4>Category</h4>
							<div class="title-divider">
								<div class="line"></div>
								<i class="fa fa-star-o"></i>
								<div class="line"></div>
							</div>
						</div>

						<div class="cat-wrap shadow-1">
							<h5><i class="fa fa-heart bgblue-1 white"></i>Local Service Category </h5>
							<div class="cat-list-wrap">
								<ul class="cat-list">
									<?php
									$sql = "SELECT tblcategory.Category, tblcategory.ID, count(tblperson.ID) as total from tblperson join tblCategory on tblperson.Category = tblcategory.ID group by tblperson.Category";
									$query = $dbh->prepare($sql);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);

									$cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $row) { ?>
											<li><a href="view-category-detail.php?viewid=<?php echo htmlentities($row->ID); ?>"><?php echo htmlentities($row->Category); ?>
													<span>(<?php echo htmlentities($row->total); ?>)</span></a></li>
											<?php $cnt = $cnt + 1;
										}
									} ?>
								</ul>
							</div>
						</div>
						<div class="listing-border-bottom bgblue-1"></div>
					</div>

					<!-- RIGHT SIDE - MAP SECTION -->
					<div class="col-md-7 col-sm-12 map-column">
						<div class="section-title-wrap margin-bottom-30"><!-- section title -->
							<h4>Service Provider Map</h4>
							<div class="title-divider">
								<div class="line"></div>
								<i class="fa fa-map-marker"></i>
								<div class="line"></div>
							</div>
						</div>

						<!-- Map Container -->
						<div id="map"></div>
					</div>
				</div>
			</div><!-- section container end -->
		</section>

		<?php include_once('includes/footer.php'); ?>
	</div>


	<!--================================JQuery===========================================-->

	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script src="js/jquery.js"></script><!-- jquery 1.11.2 -->
	<script src="js/jquery.easing.min.js"></script>
	<script src="js/modernizr.custom.js"></script>

	<!--================================BOOTSTRAP===========================================-->

	<script src="bootstrap/js/bootstrap.min.js"></script>

	<!--================================NAVIGATION===========================================-->

	<script type="text/javascript" src="js/menu.js"></script>

	<!--================================SLIDER REVOLUTION===========================================-->

	<script type="text/javascript" src="assets/revolution_slider/js/revolution-slider-tool.js"></script>
	<script type="text/javascript" src="assets/revolution_slider/js/revolution-slider.js"></script>

	<!--================================OWL CARESOUL=============================================-->

	<script src="js/owl.carousel.js"></script>
	<script src="js/triger.js" type="text/javascript"></script>

	<!--================================FunFacts Counter===========================================-->

	<script src="js/jquery.countTo.js"></script>

	<!--================================jquery cycle2=============================================-->

	<script src="js/jquery.cycle2.min.js" type="text/javascript"></script>

	<!--================================waypoint===========================================-->

	<script type="text/javascript" src="js/jquery.waypoints.min.js"></script><!-- Countdown JS FILE -->

	<!--================================RATINGS===========================================-->

	<script src="js/jquery.raty-fa.js"></script>
	<script src="js/rate.js"></script>

	<!--================================ testimonial ===========================================-->
	<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">

			<div class="rg-image-wrapper">
				<div class="rg-image"></div>
				<div class="rg-caption-wrapper">
					<div class="rg-caption" style="display:none;">
						<p></p>
						<h5></h5>
						<div class="caption-metas">
							<p class="position"></p>
							<p class="orgnization"></p>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</script>
	<script type="text/javascript" src="assets/testimonial/js/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="assets/testimonial/js/jquery.elastislide.js"></script>
	<script type="text/javascript" src="assets/testimonial/js/gallery.js"></script>

	<!--================================LEAFLET JS===========================================-->
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
	<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
	<script>
		console.log("Leaflet script starting...");

		// Wait for both DOM and Leaflet to be ready
		document.addEventListener('DOMContentLoaded', function () {
			console.log("DOM loaded, initializing map...");

			try {
				// Check if map container exists
				const mapContainer = document.getElementById('map');
				if (!mapContainer) {
					console.error("Map container not found!");
					return;
				}
				console.log("Map container found");

				// Default center (you can adjust this to your preferred default location)
				const defaultLat = 27.7172; // Example: Kathmandu latitude
				const defaultLng = 85.3240; // Example: Kathmandu longitude

				// Initialize map
				const map = L.map('map').setView([defaultLat, defaultLng], 13);
				console.log("Map initialized");

				// Add tile layer
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution: '&copy; OpenStreetMap contributors'
				}).addTo(map);
				console.log("Tile layer added");

				// Service provider icon
				const workerIcon = L.icon({
					iconUrl: 'https://cdn-icons-png.flaticon.com/512/2967/2967350.png',
					iconSize: [30, 30],
					iconAnchor: [15, 30]
				});

				// Fetch service providers from database
				<?php
				try {
					// Fetch service providers from tblperson table
					$sqlProviders = "SELECT Name, Category, Latitude, Longitude, MobileNumber, Address, City, Email FROM tblperson WHERE Latitude IS NOT NULL AND Longitude IS NOT NULL AND Latitude != '' AND Longitude != ''";
					$queryProviders = $dbh->prepare($sqlProviders);
					$queryProviders->execute();
					$providers = $queryProviders->fetchAll(PDO::FETCH_OBJ);

					// Convert PHP data to JavaScript array
					echo "const serviceProviders = [";
					$providerArray = [];
					$validProviders = 0;

					foreach ($providers as $provider) {
						// Only add if latitude and longitude are valid numbers
						if (is_numeric($provider->Latitude) && is_numeric($provider->Longitude)) {
							$validProviders++;
							$providerArray[] = "{
							lat: " . floatval($provider->Latitude) . ",
							lng: " . floatval($provider->Longitude) . ",
							name: '" . addslashes($provider->Name) . "',
							category: '" . addslashes($provider->Category) . "',
							mobile: '" . addslashes($provider->MobileNumber) . "',
							address: '" . addslashes($provider->Address) . "',
							city: '" . addslashes($provider->City) . "',
							email: '" . addslashes($provider->Email) . "'
						}";
						}
					}
					echo implode(",\n\t\t\t\t", $providerArray);
					echo "];";
					echo "console.log('Found " . $validProviders . " valid service providers');";
				} catch (Exception $e) {
					echo "const serviceProviders = [];";
					echo "console.error('Database error: " . addslashes($e->getMessage()) . "');";
				}
				?>

				console.log("Service providers data:", serviceProviders);

				// Add markers for each service provider
				if (serviceProviders && serviceProviders.length > 0) {
					serviceProviders.forEach((provider, index) => {
						console.log(`Adding marker ${index + 1}:`, provider);
						try {
							L.marker([provider.lat, provider.lng], { icon: workerIcon })
								.addTo(map)
								.bindPopup(`
								<div style="min-width: 250px;">
									<strong>${provider.name}</strong><br>
									<strong>Category:</strong> ${provider.category}<br>
									<strong>Mobile:</strong> ${provider.mobile}<br>
									<strong>Email:</strong> ${provider.email}<br>
									<strong>City:</strong> ${provider.city}<br>
									<strong>Address:</strong> ${provider.address}
								</div>
							`);
						} catch (markerError) {
							console.error(`Error adding marker ${index + 1}:`, markerError);
						}
					});
				} else {
					console.log("No service providers found or data is empty");
					// Add a sample marker to verify map is working
					L.marker([defaultLat, defaultLng])
						.addTo(map)
						.bindPopup("No service providers found in database")
						.openPopup();
				}

				// Force map to refresh
				setTimeout(() => {
					map.invalidateSize();
					console.log("Map size invalidated");
				}, 100);

				// Get user's current location if available
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function (position) {
						const userLat = position.coords.latitude;
						const userLng = position.coords.longitude;
						console.log("User location found:", userLat, userLng);

						// Custom user marker
						const userIcon = L.icon({
							iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
							iconSize: [25, 25],
							iconAnchor: [12, 25]
						});

						const userMarker = L.marker([userLat, userLng], { icon: userIcon })
							.addTo(map)
							.bindPopup("Your Current Location")
							.openPopup();

						// Center map on user location
						map.setView([userLat, userLng], 13);

					}, function (error) {
						console.log("Geolocation error: " + error.message);
					});
				} else {
					console.log("Geolocation not supported");
				}

			} catch (error) {
				console.error("Error initializing map:", error);
			}
		});
	</script>

	<!--================================custom script===========================================-->

	<script type="text/javascript" src="js/custom.js"></script>

</body>

</html>