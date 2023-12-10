document.addEventListener('DOMContentLoaded', function () {
    function showFields() {
        var productType = document.getElementById("productType").value;
        var typeSpecificFieldsDiv = document.getElementById("typeSpecificFields");

        typeSpecificFieldsDiv.innerHTML = "";

        switch (productType) {
            case "DVD":
                typeSpecificFieldsDiv.innerHTML = `
                <div id="dvd">
                <div class="mt-3">
                    <p class="mt-2 mb-2">Please, provide size</p>
                    <div class="d-flex align-items-center">
                        <div class="label-margin">
                            <label for="size">Size (MB)</label>
                        </div>
                        <div class="flex">
                            <input type="number" class="form-control" id="size" name="size_mb">
                        </div>
                    </div>
                </div>
            </div>
                `;
                break;
            case "Book":
                typeSpecificFieldsDiv.innerHTML = `
                    <div id="book">
                        <div class="mt-3">
                            <p class="mt-2 mb-2">Please, provide weight</p>
                            <div class="form-group d-flex align-items-center">
                                <div class="label-margin">
                                    <label for="weight">Weight KG</label>
                                </div>
                                <div class="flex">
                                    <input type="text" class="form-control" id="weight" name="book_weight">
                                </div>
                            </div>
                        </div>
                    </div>`;
                break;
            case "Furniture":
                typeSpecificFieldsDiv.innerHTML = `
                <div id="furniture">
                <div class="mt-3">
                    <p class="mt-2 mb-2">Please, provide dimensions</p>
                    <div class="d-flex align-items-center p-1">
                        <div class="label-margin">
                            <label for="height">Height (CM)</label>
                        </div>
                        <div class="flex">
                            <input type="text" class="form-control" id="height" name="furniture_height">
                        </div>
                    </div>
                    <div class="d-flex align-items-center p-1">
                        <div class="label-margin">
                            <label for="width">Width (CM)</label>
                        </div>
                        <div class="flex">
                            <input type="text" class="form-control" id="width" name="furniture_width">
                        </div>
                    </div>
                    <div class="d-flex align-items-center p-1">
                        <div class="label-margin">
                            <label for="length">Length (CM)</label>
                        </div>
                        <div class="flex">
                            <input type="text" class="form-control" id="length" name="furniture_length">
                        </div>
                    </div>
                </div>
            </div>
                `;
                break;
            default:
                typeSpecificFieldsDiv.innerHTML = 'Please, provide size. Size (MB): <input type="text" name="size_mb" required>';
                break;
        }
    }

    document.getElementById('product_form').addEventListener('submit', function (event) {
        var sku = document.getElementById('sku').value;
        var name = document.getElementById('name').value;
        var price = document.getElementById('price').value;
        var typeSwitcher = document.getElementById('productType').value;

        if (!sku || !name || !price || isNaN(price) || typeSwitcher === "Select Type") {
            alert('Please, submit required data');
            event.preventDefault(); 
        }
    });



    showFields();
    document.getElementById("productType").addEventListener("change", showFields);
});

