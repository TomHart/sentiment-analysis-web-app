<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Think What Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.print.css") }}" media="print">
    <script src="{{ asset("vendor/scribe/js/theme-default-3.3.0.js") }}"></script>

    <link rel="stylesheet"
          href="//unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="//unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>


</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">
<a href="#" id="nav-button">
      <span>
        MENU
        <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
      </span>
</a>
<div class="tocify-wrapper">
                <div class="lang-selector">
                            <a href="#" data-language-name="bash">bash</a>
                            <a href="#" data-language-name="javascript">javascript</a>
                    </div>
        <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>

    <ul id="toc">
    </ul>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
                    </ul>
            <ul class="toc-footer" id="last-updated">
            <li>Last updated: July 3 2021</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">http://web-app.test</code></pre>

        <h1>Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p>

        <h1 id="endpoints">Endpoints</h1>
    <p>
        
    </p>

            <h2 id="endpoints-GETapi-analyse">Analyse a message</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint allows you to analyse a message using a trained brain.</p>
<aside class="notice">The brain used is the one linked to your API key</aside>

<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://web-app.test/api/analyse?text=quam" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://web-app.test/api/analyse"
);

let params = {
    "text": "quam",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>

            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre>
            <code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
access-control-allow-origin: *
 </code>
            </pre>
        </details>         <pre>
                <code class="language-json">

{
    &quot;result&quot;: &quot;neutral&quot;,
    &quot;accuracy&quot;: {
        &quot;positive&quot;: 0.5,
        &quot;negative&quot;: 0.5
    }
}
 </code>
        </pre>
    <div id="execution-results-GETapi-analyse" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-analyse"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-analyse"></code></pre>
</div>
<div id="execution-error-GETapi-analyse" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-analyse"></code></pre>
</div>
<form id="form-GETapi-analyse" data-method="GET"
      data-path="api/analyse"
      data-authed="1"
      data-hasfiles="0"
      data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}'
      onsubmit="event.preventDefault(); executeTryOut('GETapi-analyse', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/analyse</code></b>
        </p>
                <p>
            <label id="auth-GETapi-analyse" hidden>Authorization header:
                <b><code>Bearer </code></b><input type="text"
                                                                name="Authorization"
                                                                data-prefix="Bearer "
                                                                data-endpoint="GETapi-analyse"
                                                                data-component="header"></label>
        </p>
                    <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                    <p>
                <b><code>text</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="text" data-endpoint="GETapi-analyse" data-component="query" required  hidden>
<br>
<p>The message to be analysed</p>            </p>
                </form>

            <h2 id="endpoints-GETapi-train">Train the brain</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint allows you to insert some training data to your brain</p>
<aside class="notice">The brain used is the one linked to your API key</aside>

<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://web-app.test/api/train?text=ut&amp;sentiment=positive" \
    --header "Authorization: Bearer {YOUR_AUTH_KEY}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://web-app.test/api/train"
);

let params = {
    "text": "ut",
    "sentiment": "positive",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>

            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre>
            <code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 58
access-control-allow-origin: *
 </code>
            </pre>
        </details>         <pre>
                <code class="language-json">

{
    &quot;total_words&quot;: 1,
    &quot;positive_words&quot;: 1,
    &quot;negative_words&quot;: 0
}
 </code>
        </pre>
    <div id="execution-results-GETapi-train" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-train"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-train"></code></pre>
</div>
<div id="execution-error-GETapi-train" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-train"></code></pre>
</div>
<form id="form-GETapi-train" data-method="GET"
      data-path="api/train"
      data-authed="1"
      data-hasfiles="0"
      data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}'
      onsubmit="event.preventDefault(); executeTryOut('GETapi-train', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/train</code></b>
        </p>
                <p>
            <label id="auth-GETapi-train" hidden>Authorization header:
                <b><code>Bearer </code></b><input type="text"
                                                                name="Authorization"
                                                                data-prefix="Bearer "
                                                                data-endpoint="GETapi-train"
                                                                data-component="header"></label>
        </p>
                    <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                    <p>
                <b><code>text</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="text" data-endpoint="GETapi-train" data-component="query" required  hidden>
<br>
<p>The message to be analysed</p>            </p>
                    <p>
                <b><code>sentiment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="sentiment" data-endpoint="GETapi-train" data-component="query" required  hidden>
<br>
<p>What type of sentence is it, 'positive', or 'negative'.</p>            </p>
                </form>

    

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                            </div>
            </div>
</div>
<script>
    $(function () {
        var exampleLanguages = ["bash","javascript"];
        setupLanguages(exampleLanguages);
    });
</script>
</body>
</html>