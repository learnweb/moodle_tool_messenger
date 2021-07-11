@tool @tool_messenger
Feature: Autogenerated dataintegrity check

  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 1 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3 |
      | knockoutdate | 1625068800 |
      | priority | 0 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 2 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3 |
      | knockoutdate | 1625068800 |
      | priority | 1 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 3 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3 |
      | knockoutdate | 1625068800 |
      | priority | 2 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 4 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3 |
      | knockoutdate | 1625068800 |
      | priority | 3 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 5 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3 |
      | knockoutdate | 1625068800 |
      | priority | 4 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 1 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4 |
      | knockoutdate | 1625068800 |
      | priority | 0 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 2 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4 |
      | knockoutdate | 1625068800 |
      | priority | 1 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 3 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4 |
      | knockoutdate | 1625068800 |
      | priority | 2 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 4 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4 |
      | knockoutdate | 1625068800 |
      | priority | 3 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 5 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4 |
      | knockoutdate | 1625068800 |
      | priority | 4 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 1 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 5 |
      | knockoutdate | 1625068800 |
      | priority | 0 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 2 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 5 |
      | knockoutdate | 1625068800 |
      | priority | 1 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 3 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 5 |
      | knockoutdate | 1625068800 |
      | priority | 2 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 4 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 5 |
      | knockoutdate | 1625068800 |
      | priority | 3 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 5 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 5 |
      | knockoutdate | 1625068800 |
      | priority | 4 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 1 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4 |
      | knockoutdate | 1625068800 |
      | priority | 0 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 2 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4 |
      | knockoutdate | 1625068800 |
      | priority | 1 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 3 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4 |
      | knockoutdate | 1625068800 |
      | priority | 2 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 4 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4 |
      | knockoutdate | 1625068800 |
      | priority | 3 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 5 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4 |
      | knockoutdate | 1625068800 |
      | priority | 4 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 1 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,5 |
      | knockoutdate | 1625068800 |
      | priority | 0 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 2 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,5 |
      | knockoutdate | 1625068800 |
      | priority | 1 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 3 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,5 |
      | knockoutdate | 1625068800 |
      | priority | 2 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 4 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,5 |
      | knockoutdate | 1625068800 |
      | priority | 3 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 5 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,5 |
      | knockoutdate | 1625068800 |
      | priority | 4 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 1 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4,5 |
      | knockoutdate | 1625068800 |
      | priority | 0 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 2 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4,5 |
      | knockoutdate | 1625068800 |
      | priority | 1 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 3 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4,5 |
      | knockoutdate | 1625068800 |
      | priority | 2 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 4 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4,5 |
      | knockoutdate | 1625068800 |
      | priority | 3 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 5 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 4,5 |
      | knockoutdate | 1625068800 |
      | priority | 4 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 1 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4,5 |
      | knockoutdate | 1625068800 |
      | priority | 0 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 2 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4,5 |
      | knockoutdate | 1625068800 |
      | priority | 1 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 3 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4,5 |
      | knockoutdate | 1625068800 |
      | priority | 2 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 4 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4,5 |
      | knockoutdate | 1625068800 |
      | priority | 3 |
      | instant | 1 |


  Scenario: Autogenerated Scenario for dataintegrity
    Given I log in as "admin"
    And I navigate to "Plugins > Admin tools > Admin messenger > Send message" in site administration 
    And I set the following fields to these values:
      | Subject | Testsubject |
      | Message | Testmessage |
      | Send to | 3,4,5 |
      | knockout_enable | 1 |
      | knockout_date[day] | 1 |
      | knockout_date[month] | July |
      | knockout_date[year] | 2021 |
      | Priority | 5 |
      | Send immediately | 1 |
    And I press "Send message"
    Then there should be a persistent with the following data:
      | message | Testmessage |
      | subject | Testsubject |
      | roleids | 3,4,5 |
      | knockoutdate | 1625068800 |
      | priority | 4 |
      | instant | 1 |

