<?php


use App\Services\PalindromeChecker;
use PHPUnit\Framework\TestCase;

class PalindromeCheckerTest extends TestCase
{
    /**
     * Test le cas d'un palindrome en majuscules
     */
    public function testPalindromeUpper()
    {
        $palindromeChecker = new PalindromeChecker('ABBA');
        $result = $palindromeChecker->isPalindrome();

        $this->assertEquals(true, $result);
    }

    /**
     * Test le cas d'un palindrome avec des espaces dans la chaine
     */
    public function testPalindromeUpperSpaces()
    {
        $palindromeChecker = new PalindromeChecker('A B B A');
        $result = $palindromeChecker->isPalindrome();

        $this->assertEquals(true, $result);
    }

    /**
     * Test le cas ou la chaine n'est pas un palindrome
     */
    public function testIsNotPalindrome()
    {
        $palindromeChecker = new PalindromeChecker('joel');
        $result = $palindromeChecker->isPalindrome();

        $this->assertEquals(false, $result);
    }

    /**
     * Test le cas ou la chaine n'est pas un palindrome avec des espaces dans la chaine
     */
    public function testIsNotPalindromeSpaces()
    {
        $palindromeChecker = new PalindromeChecker('j o e l');
        $result = $palindromeChecker->isPalindrome();

        $this->assertEquals(false, $result);
    }


}