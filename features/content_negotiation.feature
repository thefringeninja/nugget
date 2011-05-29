Feature: Content Negotiation

Scenario: Accepts
    Given a nugget "Conneg"
        And the nugget is using component "ContentNegotiation"
    And the "Accept" header is "application/json"
    When I request "/conneg/simple"
    Then the "Content-type" response header should be "application/json"
        And the response body should be json

