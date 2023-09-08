<div class="container">
    <div class="col-xl-6">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card mx-auto" style="width: 300px;">
                    <div class="card-body p-3">
                        <div class="row justify-content-center">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah Invoice</p>
                                <div class="form-floating mb-3">
                                </div>
                                <form method="post" action="">
                                    <input class="form-control" style="height: 45px; width: 200px;" name="jum" id="nama" type="text" pattern="[0-9.]*" required>
                                    <button class="btn btn-danger mt-3" type="submit" action="" name="qtyvariant">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="desktopTableContainer">
    <div class="card-body p-3">
        <div class="row">
            <div class="col-12">
                <div class="numbers">
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header pb-0 mb-2">
                                </div>
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive">
                                        <form id="contact-form" action="" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
                                            <table class="table align-items-center justify-content-center mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Invoice</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SKU</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Req User</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipe</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                    <?php
                                                    if (isset($_POST['qtyvariant'])) {
                                                        $jum = $_POST['jum'];
                                                        $s = 1;
                                                        $jumlah = $jum + $s;
                                                        for ($i = 1; $i < $jumlah; $i++) {
                                                    ?>
                                                            <tr>
                                                                <th><?= $s++; ?></th>

                                                                <td><input type="text" name="inv[]" class="form-control"></td>

                                                                <td><input type="text" name="sku[]" class="form-control"></td>

                                                                <td>

                                                                    <select id="selectReq" name="status" class="form-control">

                                                                        <option value="Request">Request</option>

                                                                    </select>

                                                                </td>

                                                                <td><input readonly type="text" name="requester" value="<?= $_SESSION['nama_user']; ?>" class="form-control"></td>

                                                                <td>

                                                                    <select id="selectReq" name="tipe_pesanan[]" class="form-control">
                                                                        <option value="Reguler">Reguler</option>
                                                                        <option value="Instant">Instant</option>
                                                                    </select>

                                                                </td>

                                                                <td>

                                                                    <input type="text" pattern="[0-9.]*" name="quantity[]" class="form-control">
                                                                    <input type="hidden" value="unprocessed" name="stat">
                                                                </td>

                                                                <td>
                                                                    <button class="btn btn-success btn-sm" type="button" onclick="addNewRowBaru(this)">Add</button>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <div class="text-end m-4">
                                                <button type="submit" class="btn btn-danger" name="tokoinput">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="mobileCardContainer" class="d-none">
    <div class="container justify-content-center">
        <div class="row">
            <?php
            if (isset($_POST['qtyvariant'])) {
                $jum = $_POST['jum'];
                $s = 1;
                $jumlah = $jum + $s;
                for ($i = 1; $i < $jumlah; $i++) {
            ?>
                    <form id="contact-form" action="" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                <div class="card mx-auto" style="width: 300px;">
                                    <div class="card-body p-3">
                                        <div class="row justify-content-center">
                                            <div class="numbers">
                                                <div class="card-body p-3 text-center"> <!-- Added "text-center" class -->
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">ISI DATA</p>
                                                        <br>
                                                        <div class="mb-2">
                                                            <input type="text" id="invoiceInput-<?= $i ?>" name="inv[]" class="form-control invoice-input" placeholder="Invoice">
                                                        </div>
                                                        <div id="input-section-<?= $i ?>"> <!-- Unique identifier for input section -->
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <input type="text" name="sku[]" class="form-control" placeholder="SKU" style="width:125px;">
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="text" pattern="[0-9.]*" name="quantity[]" class="form-control" placeholder="Quantity">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="output-section-<?= $i ?>"> <!-- Unique identifier for output section -->
                                                            <div class="col-12">
                                                                <select id="selectReq<?= $i ?>" name="tipe_pesanan[]" class="form-control" onchange="copySelectedValue(this, <?= $i ?>)">
                                                                    <option value="Reguler">Reguler</option>
                                                                    <option value="Instant">Instant</option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" id="input-element<?= $i ?>" name="ambil" value="Reguler">
                                                            <textarea name="note" id="" cols="30" rows="2" placeholder="note" class="form-control mt-2"></textarea>
                                                            <input readonly type="text" name="requester" value="<?= $_SESSION['nama_user']; ?>" class="form-control mb-2">
                                                            <input type="text" value="request" name="status">
                                                            <input type="text" value="unprocessed" name="stat">
                                                            <input type="text" id="invCount-<?= $i ?>" name="invCount[]" value="1">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between mt-2">
                                                        <div class="text-start">
                                                            <button type="button" class="btn btn-success" style="border-radius: 50%;" onclick="deleteRow('<?= $i ?>')">-</button>
                                                        </div>
                                                        <div class="mx-2"></div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-danger" style="border-radius: 50%;" onclick="addNewRow('<?= $i ?>')">+</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
    </div>
<?php
                    echo '<br>';
                }
            }
?>
<div class="text-end me-3">
    <button type="submit" class="btn btn-danger" name="request">Submit</button>
</div>
</form>
</div>
<br>
<script>
    function addSKUAndQuantity() {
        var skuInput = document.querySelectorAll('input[name="sku[]"]');
        var quantityInput = document.querySelectorAll('input[name="quantity[]"]');
        var outputSection = document.getElementById('output-section');

        var skuArray = [];
        var quantityArray = [];

        for (var i = 0; i < skuInput.length; i++) {
            skuArray.push(skuInput[i].value);
            quantityArray.push(quantityInput[i].value);
        }

        // Clear the output section before adding the new content
        outputSection.innerHTML = '';

        // You can use skuArray and quantityArray to do something with the data, if needed
    }

    // Function to update the input value when the select option changes
    function updateInputValue(selectElement) {
        var selectedValue = selectElement.value;
        var cardId = selectElement.id.replace('selectReq', ''); // Extract cardId from select's ID
        var inputElement = document.getElementById('input-element' + cardId);
        inputElement.value = selectedValue;
    }

    // Function to clear the output section
    function clearOutput() {
        var outputSection = document.getElementById('output-section');
        outputSection.innerHTML = '';
    }

    function deleteRow(cardId) {
        var inputSection = document.getElementById('input-section-' + cardId);
        var rows = inputSection.getElementsByClassName('row mb-2');

        if (rows.length > 1) {
            inputSection.removeChild(rows[rows.length - 1]);
        }
        var invCountInput = document.getElementById('invCount-' + cardId);
        if (invCountInput) {
            var currentCount = parseInt(invCountInput.value);
            if (currentCount > 0) {
                invCountInput.value = currentCount - 1;
            }
        }

        updateInvCount();
    }



    function addNewRow(cardId) {
        var inputSection = document.getElementById('input-section-' + cardId);
        var newRow = document.createElement('div');
        newRow.className = "row mb-2";
        var i = cardId;

        var inputElementValue = document.getElementById('input-element' + cardId).value;
        newRow.innerHTML = `
        <input type="text" id="invoiceInput-${i}" name="inv[]" class="invoice-input">
            <div class="col-6">
                <input type="text" name="sku[]" class="form-control" placeholder="SKU" style="width:125px;">
            </div>
            <div class="col-6">
                <input type="text" pattern="[0-9.]*" name="quantity[]" class="form-control" placeholder="Quantity">
            </div>
            <input readonly type="text" name="requester" value="<?= $_SESSION['nama_user']; ?>">
            <input type="text" name="tipe_pesanan[]" value="${inputElementValue}" readonly>
            <input type="text" value="request" name="status" readonly>
            <input type="text" value="unprocessed" name="stat" readonly>
        `;


        inputSection.appendChild(newRow);

        var invInput = newRow.querySelector('.invoice-input');
        var invoiceInput = document.getElementById('invoiceInput-' + cardId);

        invInput.addEventListener('input', function() {
            invoiceInput.value = this.value;
        });

        var invoiceValue = invoiceInput.value;
        invInput.value = invoiceValue;

        var invCountInput = document.getElementById('invCount-' + cardId);
        if (invCountInput) {
            var currentCount = parseInt(invCountInput.value);
            invCountInput.value = currentCount + 1;
        }

        updateInvCount(); // Memperbarui nilai invCount setiap kali elemen ditambahkan

    }

    function copySelectedValue(selectElement, cardId) {
        var selectedValue = selectElement.value;
        var inputElement = document.getElementById('input-element' + cardId);
        inputElement.value = selectedValue;
    }

    function updateInvCount() {
        var jumlahInv = document.querySelectorAll('input[name="inv[]"]').length;
        var invCountInput = document.getElementById('invCount');
        invCountInput.value = jumlahInv; // Mengatur nilai invCount sesuai jumlah elemen inv[]
    }

    function setInputValue(cardId) {
        var inputElementValue = document.getElementById('input-element' + cardId).value;
        var ambilInput = document.getElementById('input-element' + cardId).querySelector('input[name="ambil"]');
        ambilInput.value = inputElementValue;
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // JavaScript code

    // Function to initialize the DataTable
    function initializeDataTable() {
        if (!$.fn.DataTable.isDataTable('#myTable')) {
            const dataTable = $('#myTable').DataTable({
                // Add your DataTable initialization options here
            });

            // Handle pagination events
            dataTable.on('page.dt', function() {
                showMobileCards();
            });
        }
    }

    // Function to handle card clicks
    function handleCardClick(event) {
        event.preventDefault();
        // Add your logic here for card click event
    }

    // Function to show mobile cards based on pagination
    function showMobileCards() {
        const startIndex = (mobileCurrentPage - 1) * mobileItemsPerPage;
        const endIndex = startIndex + mobileItemsPerPage;

        $('#mobileCardContainer .card').hide();
        $('#mobileCardContainer .card').slice(startIndex, endIndex).show();
    }

    // Variables to track pagination state
    let mobileCurrentPage = 1;
    const mobileItemsPerPage = 10; // Number of items to show per page

    // Check the viewport width and show/hide elements based on screen size
    function updateLayout() {
        const desktopTableContainer = document.getElementById('desktopTableContainer');
        const mobileCardContainer = document.getElementById('mobileCardContainer');

        if (window.innerWidth < 1080 && window.innerHeight < 900) {
            desktopTableContainer.style.display = 'none';
            mobileCardContainer.classList.remove('d-none');

            // Initialize DataTable
            initializeDataTable();
            showMobileCards();
        } else {
            desktopTableContainer.style.display = 'block';
            mobileCardContainer.classList.add('d-none');

            // Destroy DataTable
            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy();
            }
        }
    }

    // Initial layout update on page load
    updateLayout();

    // Listen for window resize events and update layout accordingly
    window.addEventListener('resize', updateLayout);

    // Handle mobile pagination events
    $('#mobilePreviousPage').click(function(event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            mobileCurrentPage--;
            showMobileCards();
        }
    });

    $('#mobileNextPage').click(function(event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')) {
            mobileCurrentPage++;
            showMobileCards();
        }
    });

    // Attach click event listeners to each card
    const cards = document.querySelectorAll('#mobileCardContainer .card');
    cards.forEach(function(card) {
        card.addEventListener('click', handleCardClick);
    });
</script>
<script>
    // JavaScript to hide the data when the user is on a mobile device
    document.addEventListener("DOMContentLoaded", function() {
        var isMobile = <?php echo $_SESSION['is_mobile'] ? 'true' : 'false'; ?>;
        if (isMobile) {
            var dataContainer = document.getElementById("dataContainer");
            dataContainer.style.display = "none";
        }
    });
</script>

<script>
    var rowData = [];

    // Function to update rowData array with the current values of the input fields
    function updateRowDataBaru() {
        rowData = [
            document.querySelector('input[name="inv[]"]').value,
            document.querySelector('input[name="sku[]"]').value,
            document.querySelector('select[name="status"]').value,
            document.querySelector('input[name="quantity[]"]').value
        ];
    }

    // Function to add a new row to the table
    function addNewRowBaru(button) {
        updateRowDataBaru();

        var newRow = button.parentNode.parentNode.cloneNode(true);
        var inputs = newRow.getElementsByTagName('input');
        var selects = newRow.getElementsByTagName('select');

        // Populate the new row with the values from rowData array
        for (var y = 1; y < inputs.length; y++) {
            inputs[y].value = rowData[y];
        }

        // Set the requester input field value to the session value
        newRow.querySelector('input[name="requester"]').value = '<?= $_SESSION['nama_user']; ?>';
        newRow.querySelector('input[name="stat"]').value = 'unprocessed';


        // Change the "ADD" button to a "DELETE" button for the new row
        var deleteButton = document.createElement('button');
        deleteButton.classList.add('btn', 'btn-danger', 'mt-0', 'btn-sm');
        deleteButton.textContent = ' DEL ';
        deleteButton.type = 'button';
        deleteButton.onclick = function() {
            deleteRowBaru(this);
        };
        newRow.getElementsByTagName('td')[6].innerHTML = ''; // Clear the existing "ADD" button
        newRow.getElementsByTagName('td')[6].appendChild(deleteButton); // Add the "DELETE" button

        // Copy the selected value of the previous row's "Tipe" dropdown
        var previousSelect = button.parentNode.parentNode.getElementsByTagName('select')[1];
        selects[1].value = previousSelect.value;

        // Insert the new row below the current row
        button.parentNode.parentNode.parentNode.insertBefore(newRow, button.parentNode.parentNode.nextSibling);
    }

    function deleteRowBaru(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>