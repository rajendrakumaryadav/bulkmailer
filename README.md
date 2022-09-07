### Simple Mailer Application
 - This system accept CSV File which contain email in its last column.
 - Before last column any number of comma seperate value may be in the file.

```csv
name, school, class, email
ABC, Example High Secondary, III, example@example.com

```

- We can compose mail using the above csv file.
It will be something like.

```
Dear {#0#},
Your Admission for class {#2#} in {#1#} is confirmed.

Thank you,
Team Admission Cell - {#1#}
```
