import { defineConfig } from 'astro/config';

// Static output: the built site in dist/ deploys to any Apache/PHP host
// (same hosting as the old PHP site). js/owlmail.php in public/ is served
// as-is so the contact form keeps working on PHP hosting.
export default defineConfig({
  site: 'https://www.rayinfos.com',
  output: 'static',
  build: {
    format: 'file'
  }
});
