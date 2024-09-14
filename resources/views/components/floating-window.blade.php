@push('css')
    <style>
        #openWindowBtn {
            margin: 20px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 3;
            backdrop-filter: blur(5px);
            /* Applies blur to the background */
        }

        .floating-window {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Centers the window */
            width: 500px;
            height: 500px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            display: none;
            /* Initially hidden */
            z-index: 5;
            overflow: hidden;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .floating-header {
            background-color: #f1f1f1;
            padding: 10px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .floating-body {
            padding: 15px;
        }

        .floating-footer {
            padding: 10px;
            text-align: center;
            /* background-color: #f1f1f1; */
        }
    </style>
@endpush
<button id="openWindowBtn">Create Product</button>
<div id="overlay" class="overlay"></div>

<div id="floatingWindow" class="floating-window">
    <div class="floating-header">
        <div class="title">{{  $title  }}</div>
        <button id="closeWindowBtn" class="close-btn">&times;</button>

    </div>
    <div class="floating-body">
    </div>
    <div class="floating-footer">
        <!-- <button id="submit">{{ $btnName }}</button> -->
    </div>
</div>
@push('js')
    <script>
        const openWindowBtn = document.getElementById('openWindowBtn');
        const closeWindowBtn = document.getElementById('closeWindowBtn');
        const floatingWindow = document.getElementById('floatingWindow');
        const overlay = document.getElementById('overlay');

        openWindowBtn.addEventListener('click', () => {
            overlay.style.display = 'block';
            floatingWindow.style.display = 'block';
        });

        // Close the floating window and hide the overlay when "Close" button is clicked
        closeWindowBtn.addEventListener('click', () => {
            overlay.style.display = 'none';
            floatingWindow.style.display = 'none';
        });

    </script>
@endpush