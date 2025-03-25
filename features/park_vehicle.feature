Feature: Park a vehicle

  In order to not forget where I've parked my vehicle
  As an application user
  I should be able to indicate my vehicle location

  Background:
    Given my fleet
    And a vehicle with plate number "GHI321"
    And I have registered this vehicle into my fleet

  @critical
  Scenario: Successfully park a vehicle
    And a location with lat 48.8566 and lng 2.3522
    When I park my vehicle at this location
    Then the known location of my vehicle should be "48.8566,2.3522"

  Scenario: Can't localize my vehicle to the same location two times in a row
    And a location with lat 40.7128 and lng -74.0060
    And my vehicle has been parked into this location
    When I try to park my vehicle at this location
    Then I should be informed that my vehicle is already parked at this location
