
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <form action="../save_product.php" method="POST" enctype="multipart/form-data" id="product_form">

        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-md-4 offset-md-2">
                    <h2>Product Add</h2>
                </div>
                <div class="col-md-4 offset-md-2 text-right">
                    <button type="submit" class="btn btn-success mx-3">SAVE</button>
                    <a href="../index.php" class="btn btn-warning mx-3">CANCEL</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 line"></div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-4 mt-5">
                    <div class="d-flex align-items-center">
                        <div class="label-margin">
                            <label for="sku">SKU</label>
                        </div>
                        <div class="flex">
                            <input type="text" class="form-control" id="sku" name="sku">
                        </div>
                    </div>

                    <div class="d-flex align-items-center mt-3">
                        <div class="label-margin">
                            <label for="product_name">Name</label>
                        </div>
                        <div class="flex">
                            <input type="text" class="form-control" id="name" name="product_name">
                        </div>
                    </div>

                    <div class="d-flex align-items-center mt-3">
                        <div class="label-margin">
                            <label for="product_price">Price ($)</label>
                        </div>
                        <div class="flex">
                            <input type="text" class="form-control" id="price" name="product_price">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-2 mt-3">
                    <div id="dynamicForm">
                        <label for="productType">Type Switcher</label>
                        <select id="productType" name="productType" onchange="showFields()">
                            <option value="DVD">DVD</option>
                            <option value="Book">Book</option>
                            <option value="Furniture">Furniture</option>
                        </select>
                        <div id="typeSpecificFields"></div>
                    </div>
                </div>
            </div>

           
        </div>
    </form>


    <script src="../assets/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>

</html>