## Tasks
1. Make a registration form. Registree must be able to choose an account type (person or organization).
Person fields: email, fullname, tax identification number (if the person is an entrepreneur).
Organization fields: email, fullname, organization name, tax identification number.

2. Cache the function:
```php
function($date, $type) {
    $userId = Yii::$app->user->id;
    $dataList = SomeDataModel::find()->where(['date' => $date, 'type' => $type, 'user_id' => $userId])->all();
    $result = [];
    
    if (!empty($dataList)) {
        foreach ($dataList as $dataItem) {
            $result[$dataItem->id] = ['a' => $dataItem->a, 'b' => $dataItem->b];
        }
    }
}
return $result;
```

3. Create a db structure to store drug information according the following rules:
Drug has a name, a shelf life and disease list that the drug may treat.

4. Perform some code before render any page (e.g. checking a value of some db field). Use better approach.
