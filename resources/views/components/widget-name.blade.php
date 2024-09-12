<div class="widget-container">
    <h3>{{ $title }}</h3>
    <p>{{ $content }}</p>
    <button class="btn btn-primary" onclick="showMessage()">Click Me</button>
</div>

<script>
    function showMessage() {
        alert('Hello from the widget!');
    }
</script>

<style>
    .widget-container {
        background-color: #f9f9f9;
        padding: 10px;
        border-radius: 5px;
    }
</style>
