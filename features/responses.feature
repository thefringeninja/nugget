Feature: Responses

Scenario: Returns an integer
    Given a module "Test"
    When I request "/test/returns/code/404"
    Then the response code should be 404

Scenario: Returns a bare model
    Given a module "Test"
    When I request "/test/returns/model"
    Then the response code should be 200
        And the response model should not be null