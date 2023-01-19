use akademija;

# Task 3

SELECT concat(persons.first_name, ' ', persons.last_name)AS full_name, addresses.city, addresses.country_iso
FROM persons
         LEFT JOIN addresses
                   ON persons.address_id = addresses.id;

# Task 4

SELECT `groups`.title, count(person2gruop.person_id)
FROM `groups`
         LEFT JOIN person2gruop
                   ON `groups`.id = person2gruop.groups_id
         LEFT JOIN states
                   ON `groups`.state = states.id WHERE states.title = 'Active'
GROUP BY `groups`.id;

# Task 5

SELECT concat(persons.first_name, ' ', persons.last_name) AS full_name
FROM persons
         LEFT JOIN person2gruop
                   ON persons.id = person2gruop.person_id
         LEFT JOIN `groups`
                   ON `groups`.id = person2gruop.groups_id
WHERE `groups`.title LIKE '%D';

#Task 6

SELECT concat(persons.first_name, ' ', persons.last_name) AS full_name,
       concat(addresses.city, ' ', addresses.street) AS address
FROM persons
         LEFT JOIN addresses
                   ON persons.address_id = addresses.id
         JOIN person2gruop
              ON persons.id = person2gruop.person_id
         JOIN `groups`
              ON person2gruop.groups_id = `groups`.id
WHERE `groups`.title = 'CS_PHP_D';

#Task 7

SELECT *
FROM persons
         JOIN users
              ON persons.id = users.person_id
         JOIN states
              ON users.state = states.id
WHERE (persons.first_name is null OR persons.last_name is null) AND states.title = 'Inactive';

#Task 8

SELECT count(`groups`.id), concat(addresses.city, ' ', addresses.street) AS address
FROM `groups`
         LEFT JOIN addresses
                   ON `groups`.address_id = addresses.id
GROUP BY address;