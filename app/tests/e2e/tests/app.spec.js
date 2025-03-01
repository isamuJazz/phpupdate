// @ts-check
const { test, expect } = require('@playwright/test');

test.describe('CakePHP Application Tests', () => {
  test('Home page loads successfully', async ({ page }) => {
    // Navigate to the home page
    await page.goto('/');
    
    // Check that the page loaded without errors
    const title = await page.title();
    console.log(`Page title: ${title}`);
    
    // Check for the presence of the main heading
    const heading = await page.locator('h1').first();
    await expect(heading).toBeVisible();
    
    // Verify the heading text contains expected content
    const headingText = await heading.textContent();
    expect(headingText).toContain('Sample Page');
    
    // Check for PHP 8 features section
    const php8Section = await page.locator('h2:has-text("PHP 8")');
    await expect(php8Section).toBeVisible();
    
    // Check for specific PHP 8 features
    const nullsafeOperator = await page.locator('text=Nullsafe オペレーター');
    await expect(nullsafeOperator).toBeVisible();
    
    const matchExpression = await page.locator('text=Match 式');
    await expect(matchExpression).toBeVisible();
    
    const namedArguments = await page.locator('text=名前付き引数');
    await expect(namedArguments).toBeVisible();
    
    // Take a screenshot for reference
    await page.screenshot({ path: 'test-results/homepage.png' });
    
    // Check for error messages on the page
    const errorMessages = await page.locator('text=/Error|Exception|Fatal|Warning/i').count();
    expect(errorMessages).toBe(0);
    
    // Check console for errors
    const consoleMessages = [];
    page.on('console', msg => {
      if (msg.type() === 'error') {
        consoleMessages.push(msg.text());
      }
    });
    
    // Verify no console errors
    expect(consoleMessages.length).toBe(0);
  });
  
  test('Sample controller route works', async ({ page }) => {
    // Navigate to the sample controller
    await page.goto('/sample');
    
    // Check that the page loaded without errors
    const heading = await page.locator('h1').first();
    await expect(heading).toBeVisible();
    
    // Verify the heading text contains expected content
    const headingText = await heading.textContent();
    expect(headingText).toContain('Sample Page');
    
    // Take a screenshot for reference
    await page.screenshot({ path: 'test-results/sample-page.png' });
    
    // Check for error messages on the page
    const errorMessages = await page.locator('text=/Error|Exception|Fatal|Warning/i').count();
    expect(errorMessages).toBe(0);
  });
});
