<style>
    /* RESET STYLES & HELPER CLASSES */
    :root {
        --level-1: #8dccad;
        --level-2: #f5cc7f;
        --level-3: #7b9fe0;
        --level-4: #f27c8d;
        --black: black;
    }

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    ol {
        list-style: none;
    }

    body {
        margin: 50px 0 100px;
        text-align: center;
        font-family: "Inter", sans-serif;
    }

    .container {
        max-width: 1000px;
        padding: 0 10px;
        margin: 0 auto;
    }

    .rectangle {
        position: relative;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    /* LEVEL-3 STYLES */
    .level-3-wrapper {
        position: relative;
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        grid-column-gap: 20px;
        width: 90%;
        margin: 0 auto;
    }

    .level-3 {
        margin-bottom: 20px;
        background: var(--level-3);
    }

    /* LEVEL-4 STYLES */
    .level-4-wrapper {
        position: relative;
        width: 80%;
        margin-left: auto;
    }

    .level-4-wrapper::before {
        content: "";
        position: absolute;
        top: -20px;
        left: -20px;
        width: 2px;
        height: calc(100% + 20px);
        background: var(--black);
    }

    .level-4-wrapper li + li {
        margin-top: 20px;
    }

    .level-4 {
        font-weight: normal;
        background: var(--level-4);
    }

    .level-4::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0%;
        transform: translate(-100%, -50%);
        width: 20px;
        height: 2px;
        background: var(--black);
    }
</style>
<div class="container">
    <ol class="level-3-wrapper">
        <li>
            <h3 class="level-3 rectangle">Syncing URLs from N-DOPTOR</h3>
            <ol class="level-4-wrapper">
                @foreach($sync_urls as $url)
                    <li>
                        <h4 class="level-4 rectangle">{{$url}}</h4>
                    </li>
                @endforeach
            </ol>
        </li>
    </ol>
</div>
