sELECT * FROM `HumanResources.Department`

SELECT * FROM `Production.TransactionHistory`

sELECT departmentID,name,groupname, modifieddate FROM `HumanResources.Department`

sELECT groupname,count(departmentid), modifieddate FROM `HumanResources.Department`
group by groupname

sELECT count(departmentid) FROM `HumanResources.Department`
group by groupname

select * from `person.address`

select addressid, addressline1 from `person.address`
select addressline1, count(addressid) from `person.address`group by addressline1

select * from `person.address`left join `person.addresstype`
on `person.address`.addressid = `person.addresstype`.addresstypeid