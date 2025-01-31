# Components Information

Running the command will create a component in the resources/views/components directory and a component in the App/Views/Components directory with the corresponding name.

```go
// example-component being the name of the component
wp acorn make:component ExampleComponent
```

### App/View/Components Info

The render() method inside of the component in the App directory is responsable for the rentering of that component

### using the component

#### No Dynamic Values Passed

```php
// example-component being the name of the component
<x-example-component />
// will output "No Dynamic Values Passed"
```

inside resources/views/components

```php
<h2>
    No Dynamic Values Passed
</h2>
```

---

### Passing in dynamic value

```php
// example-component being the name of the component
<x-example-component class="bg-red-200" data-name="example-component">
    Hello World
</x-example-component>
// will output "Hello World"
```

inside resources/views/components

```php
// $attributes will hold all the data passed into the component tag
// $slot will hold all the data within the tags
<div {{ $attributes }}>
    {{  $slot }}
</div>
```

### Using merge functionality

Using the Merge method, data can be set as default. Once a component has been used and data is pass to within that component it will merge the data being passed with the defaulted data

inside resources/views/components

```php
//using the merge method to give default that can be overwritten
<div {{ $attributes->merge(['class'=>'bg-red-500 text-xl text-black', 'data-name'=>'example']) }}>
    {{  $slot }}
</div>
```

Within the Theme

```php
// example-component being the name of the component
<x-example-component class="bg-blue-200 text-white" data-name="example-1">
    Hello World
</x-example-component>
// will display blue button with white text and text-xl with the attribute of data-name=example-1

<x-example-component  data-name="example-2">
    Hello World
</x-example-component>
// will display red button with black text and text-xl (although no classes were passed) with the attribute of data-name=example-2

<x-example-component >
    Hello World
</x-example-component>
// will display red button with white text and text-xl with the attribute of data-name=example although nothing was passed

```

[Sage Docs](https://roots.io/sage/docs/components/#components)
