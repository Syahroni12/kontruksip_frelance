<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />


	<title>Sign In Admin</title>

	<link href="{{ asset('admin_page/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<style>
		/* Menambahkan background gradasi 4 warna */
		body {
			background: linear-gradient(45deg, #FFF8DB, #FFC7ED, #7D8ABC, #304463);
			height: 100vh;
			margin: 0;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.card {
			background: rgba(255, 255, 255, 0.2); /* Warna transparan */
			backdrop-filter: blur(10px); /* Efek blur */
			-webkit-backdrop-filter: blur(10px); /* Efek blur untuk Safari */
			border: 1px solid rgba(255, 255, 255, 0.3); /* Border ringan */
			border-radius: 10px; /* Border melengkung */
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sedikit bayangan */
			padding-top: 10%;
			padding-bottom: 10%;
		}

		/* Menambahkan margin pada label dan input */
		.form-label {
			margin-bottom: 10px;
		}

		.form-control-lg {
			margin-bottom: 30px;
			border-radius: 8px;
			padding: 10px 15px;
			font-size: 16px;
			border: 1px solid #ccc;
			transition: border-color 0.3s ease, box-shadow 0.3s ease;
		}

		/* Efek hover untuk input form */
		.form-control-lg:hover {
			border-color: #6a11cb;
			box-shadow: 0 0 10px rgba(106, 17, 203, 0.2);
		}

		/* Fokus pada input form */
		.form-control-lg:focus {
			border-color: #2575fc;
			box-shadow: 0 0 10px rgba(37, 117, 252, 0.5);
			outline: none;
		}

		/* Desain tombol sign-in */
		.btn-primary {
			background: linear-gradient(45deg, #6a11cb, #2575fc);
			border: none;
			color: white;
			padding: 10px 20px;
			font-size: 18px;
			font-weight: 600;
			border-radius: 8px;
			cursor: pointer;
			transition: transform 0.3s ease, box-shadow 0.3s ease;
		}

		/* Efek hover untuk tombol sign-in */
		.btn-primary:hover {
			transform: scale(1.05);
			box-shadow: 0px 4px 15px rgba(37, 117, 252, 0.5);
			background: linear-gradient(45deg, #2575fc, #6a11cb);
		}

		/* Desain tombol sign-in dengan Google */
		.btn-google {
			background-color: white;
			color: #757575;
			border: 1px solid #ddd;
			padding: 10px 20px;
			font-size: 18px;
			font-weight: 600;
			border-radius: 8px;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			transition: transform 0.3s ease, box-shadow 0.3s ease;
		}

		/* Menambahkan logo Google di tombol */
		.btn-google img {
			margin-right: 10px;
		}

		/* Efek hover untuk tombol sign-in dengan Google */
		.btn-google:hover {
			transform: scale(1.05);
			box-shadow: 0px 4px 15px rgba(66, 133, 244, 0.5);
			background-color: #f5f5f5;
			border-color: #f20202;
		}

		/* Divider dengan tulisan "or" */
		.divider {
			display: flex;
			align-items: center;
			text-align: center;
			margin: 30px 0;
		}

		.divider::before,
		.divider::after {
			content: '';
			flex: 1;
			border-bottom: 1px solid #ddd;
		}

		.divider:not(:empty)::before {
			margin-right: .75em;
		}

		.divider:not(:empty)::after {
			margin-left: .75em;
		}

		/* Toggle visibility untuk input password */
		.toggle-password {
			position: absolute;
			right: 10px;
			top: 10px;
			cursor: pointer;
		}

		.input-container {
			position: relative;
		}
	</style>
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form>
										<!-- Input email dengan margin -->
										<div class="mb-4">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" name="email" placeholder="Enter your email" />
										</div>

										<!-- Input password dengan toggle visibility dan margin -->
										<div class="mb-4 input-container">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" name="password" placeholder="Enter your password" autocomplete="off" />
										</div>

										<!-- Tombol sign-in -->
										<div class="d-grid gap-2 mt-3">
											<a href="" class="btn btn-lg btn-primary">Sign in</a>
										</div>

										<!-- Divider dengan tulisan "or" -->
										<div class="divider">or Sign In with</div>

										<!-- Tombol sign-in with Google -->
										<div class="d-grid gap-2 mt-5">
											<a href="index.html" class="btn btn-google">
												<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png" alt="Google Logo" width="20">
												Sign in with Google
											</a>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

</body>

</html>
