# Introduction



<aside>
    <strong>Base URL</strong>: <code>http://delivery.test</code>
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
<div>{</div>
    <div style="margin-left: 30px">"success": true,</div>
    <div style="margin-left: 30px">"message": "Item updated successfully"</div>
}
</aside>

<aside>
<aside class="warning">Status code: 422(UNPROCESSABLE_ENTITY, validation error) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"errors": {},</div>
    <div style="margin-left: 30px">"message": "The name field is required. (and 4 more errors)"</div>
}
</aside>

<aside>
<aside class="warning">Status code: 202(NO_CONTENT, internal server error) - Example Response</aside>
<div>{</div>
    <div style="margin-left: 30px">"success": false,</div>
    <div style="margin-left: 30px">"message": "An error occurred, please try again later"</div>
}
</aside>


