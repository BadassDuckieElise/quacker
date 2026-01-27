import type { LinkResolverFunction } from "@prismicio/client";

const linkResolver: LinkResolverFunction = (doc) => {
  if (doc.type === "home") return "/";
  if (doc.type === "page" && doc.uid) return `/${doc.uid}`;
  return "/";
};

export default linkResolver;
