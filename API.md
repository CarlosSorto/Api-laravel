## API

### Format

The basic format of every http request made to API is a json object with the next nodes:

```
{
  filter {},
  "data": {},
  "errors": {},
  "meta": {}
}
```

#### Nodes

* **filter:** This node it's mostly used in the index, and it's made to search resources
  * **q:** Here you can add searching query parameter to obtain a filtered collection.
    * This most be an object with a key/value pair, where the key it's the **name of the column** or the **name of scope** to use, concatenated with a **`|`** and a **`predicate`** indicating the operation to use on that column. To know the diferent predicated that you can use, check the **Search params** section.
  * **disable_pagination**: If you send this parameter with the value of 1, it will disable the pagination
  * **page**: This parameter its the current page, to filter the pagination.
* **data:**
  * In a **request**, this is node it's used to send the data, to create or update a record on the api
  * In **response**, this node it's used to store the data returned from the request.
* **errors:**
  * This node it's used to store the errors that have been ocurred in a request.
  * This is an object with a key/value pair, where they key its the name of the field that causes the error, or a generic with a field named `base`, and the value it's and array of errors.
* **meta:**
  * This node it's used to store metadata, such as total of pages, current page, etc.


### Search params

All search parameters will be in stored in an object inside the `q` key of the object `filter` object. The name of the key it's composed by `column name or scope name|predicate`

The list of available predicates are:

* **cont:** This will search for a string containing a value. Equivalent to a  `like %value%`
* **not_cont:** This will search for a string that doesn't contain a value. Equivalent to a  `like not %value%`
* **start:** This will search for a string that starts with a value. Equivalent to a  `like value%`
* **not_start:** This will search for a string that doesn't starts with a value. Equivalent to a  `like value%`
* **end:** This will search for a string that ends with a value. Equivalent to a  `like %value`
* **not_end:** This will search for a string that doesn't ends with a value. Equivalent to a  `like value%`
* **eq:** This will search for a value that match the column. Equivalent to a  `= value`
* **not_eq:** This will search for a value that doesn't match the column. Equivalent to a  `!= value`
* **in:** This will search for a value of the column inside of the array. Equivalent to a  `in (value)`
* **not_in:** This will search for a value of the column that is not inside of the array. Equivalent to a  `not in (value)`
* **is_null:** This will search a column value that is null. Equivalent to a  `IS NULL`
* **is_not_null:** This will search a column value that is not null. Equivalent to a  `IS NOT NULL`
* **gt:** This will search a column value that is greater than. Equivalent to a  `> value`
* **gteq:** This will search a column value that is greater than or equals to. Equivalent to a  `>= value`
* **lt:** This will search a column value that is less than. Equivalent to a  `< value`
* **lteq:** This will search a column value that is less than or equals to. Equivalent to a  `<= value`
* **is_true:**  This will search a column value that is true. Equivalent to a  `= true`
* **is_false:** This will search a column value that is false. Equivalent to a  `= false`
* **scp:** This is an special predicate that will look for the scope with the provided name and passes the value as argument of that scope


**Nota:** The predicate will only work if the column name it's declared in `protected static $searcheable_fields`

### Configure searcheable fields

In the model that have the searcheable trait, declare the next variable:

```
protected static $searcheable_fields = [
  'id' => [
    'type'=> "integer"
  ],
  'created_at' => [
    'type'=> "datetime"
  ],
  'updated_at' => [
    'type'=> "datetime"
  ],
  'uuid' => [
    'type'=> "string"
  ],
  'name' => [
    'type'=> "string"
  ],
  'active' => [
    'type'=> "integer"
  ],
];
```
