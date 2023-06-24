# Introduction



<aside>
    <strong>Base URL</strong>: <code>http://127.0.0.1:8000</code>
</aside>

This documentation aims to provide all the information you need to work with our API.

<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).
</aside>
<h2>Response Codes</h2>

<aside>
<aside class="success">Status code: 200(OK, request was successful) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"success": true,</div>
    <div style="margin-left: 30px">"data": [{}, {}],</div>
    <div style="margin-left: 30px">"message": "Item(s) found"</div>
<div>}</div>
</aside>

<aside>
<aside class="success">Status code: 201(CREATED, data was saved successfully) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"success": true,</div>
    <div style="margin-left: 30px">"data": [{}, {}],</div>
    <div style="margin-left: 30px">"message": "Item created successfully"</div>
<div>}</div>
</aside>

<aside>
<aside class="success">Status code: 202(ACCEPTED, update was successful) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"success": true,</div>
    <div style="margin-left: 30px">"data": [{}, {}],</div>
    <div style="margin-left: 30px">"message": "Item updated successfully"</div>
}
</aside>

<aside>
<aside class="success">Status code: 202(NO_CONTENT, deletion was successful) - Example Response</aside>
</aside>

<aside>
<aside class="warning">Status code: 422(UNPROCESSABLE_ENTITY, validation error) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"errors": {},</div>
    <div style="margin-left: 30px">"message": "The name field is required. (and 4 more errors)"</div>
}
</aside>

<aside>
<aside class="warning">Status code: 500(SERVER_ERROR, internal server error) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"success": false,</div>
    <div style="margin-left: 30px">"message": "An error occurred, please try again later"</div>
}
</aside>

<aside>
<aside class="warning">Status code: 403(FORBIDDEN, the request is not authorized) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"message": This action is unauthorized.,</div>
}
</aside>

<aside>
<aside class="warning">Status code: 404(NOT_FOUND, the resource or route not found) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"message":     "message": "No query results for model [App\Models\Restaurant] 144"</div>
}
</aside>

<h2>Filtering</h2>
Filtering only works on fetching a collection <br>
and can be done by appending ?filter[key]=value
to the url

<h3>Example</h3>
<p>
<small class="badge badge-green">GET</small>
<code>/restaurants?filter[name]=kfc</code>
</p>

<h3>You can specify multiple matching filter keys by passing a '&' separated list of key value pair</h3>
<p>
<small class="badge badge-green">GET</small>
<code>/restaurants?filter[name]=kfc&filter[location]=sunyani</code> <br>
<small>restaurants will contain all restaurants with "kfc" in their name AND "sunyani" in their location</small>
</p>

<h3>You can specify multiple matching filter values by passing a comma separated list of values</h3>
<p>
<small class="badge badge-green">GET</small>
<code>/restaurants?filter[name]=kfc,kofibusy</code> <br>
<small>restaurants will contain all restaurants that contain "kfc" OR "kofibusy" in their name</small>
</p>

<h2>Sorting</h2>
The sort query parameter is used to determine by which property
the results' collection will be ordered.
Sorting only works on fetching a collection
and can be done by appending ?sort=key to the url

<h3>Example</h3>
<p>
<small class="badge badge-green">GET</small>
<code>/restaurants?sort=name</code> <br>
<small>Restaurants will be sorted by name</small>
</p>

<h3>
Sorting is ascending by
default and can be reversed by adding a hyphen (-) to the start
of the key or property name.
</h3>
<p>
<small class="badge badge-green">GET</small>
<code>/restaurants?sort=-name</code> <br>
<small>restaurants will be sorted by name and descending (Z -> A)</small>
</p>



<h3>You can sort by multiple properties by separating them with a comma</h3>
<p>
<small class="badge badge-green">GET</small>
<code>/restaurants?sort=name,-location</code> <br>
<small>
restaurants will be sorted by name in ascending order with a secondary sort on location in descending order.
</small>
</p>


